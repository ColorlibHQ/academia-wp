<?php
/**
 * The course browser: filter, search, sort and paginate without a page load.
 *
 * How this works, and why it is not the Interactivity API:
 *
 * The theme ships every file as-is — no npm, no build step — and the
 * Interactivity API's directives are only worth their weight when you are
 * bundling a module through @wordpress/scripts. So the enhancement here is
 * the same shape core's Query block uses for enhanced pagination, done
 * directly: the server renders the complete, correct result for whatever is
 * in the query string, and ~70 lines of dependency-free JavaScript intercept
 * the form, fetch that same URL, and swap the results region in place.
 *
 * The consequence is that it degrades properly. With JavaScript off, or before
 * the script loads, the form is an ordinary GET form that filters correctly
 * with a page load — because the markup it enhances is the finished result,
 * not an empty shell waiting to be filled.
 *
 * The renderer is registered through the theme's
 * `academia_course_filter_renderer` filter rather than by declaring a function
 * of the same name. Declaring it was the original approach and it fataled: on
 * plugin *activation* WordPress has already loaded the theme, so the theme's
 * function existed and this file redeclared it — the plugin could not be
 * activated on a site running Academia at all. A filter cannot collide and does
 * not depend on load order.
 *
 * @package Academia_Library
 */

defined( 'ABSPATH' ) || exit;

/**
 * Read, validate and default the filter state from the query string.
 *
 * @return array{search:string, category:string, level:string, sort:string, paged:int}
 */
function academia_library_filter_state() {
	// phpcs:disable WordPress.Security.NonceVerification.Recommended -- read-only filters on a public archive.
	$sort    = isset( $_GET['course_sort'] ) ? sanitize_key( wp_unslash( $_GET['course_sort'] ) ) : 'date';
	$allowed = array( 'date', 'title', 'price', 'rating' );

	$state = array(
		'search'   => isset( $_GET['course_search'] ) ? sanitize_text_field( wp_unslash( $_GET['course_search'] ) ) : '',
		'category' => isset( $_GET['course_cat'] ) ? sanitize_title( wp_unslash( $_GET['course_cat'] ) ) : '',
		'level'    => isset( $_GET['course_level'] ) ? sanitize_title( wp_unslash( $_GET['course_level'] ) ) : '',
		'sort'     => in_array( $sort, $allowed, true ) ? $sort : 'date',
		'paged'    => isset( $_GET['paged'] ) ? max( 1, absint( wp_unslash( $_GET['paged'] ) ) ) : 1,
	);
	// phpcs:enable WordPress.Security.NonceVerification.Recommended

	return $state;
}

/**
 * Register this renderer with the theme.
 *
 * @param callable $renderer The theme's default renderer.
 * @return callable
 */
function academia_library_register_renderer( $renderer ) {
	return function_exists( 'academia_course_card' ) ? 'academia_library_course_filter' : $renderer;
}
add_filter( 'academia_course_filter_renderer', 'academia_library_register_renderer' );

/**
 * The course browser.
 *
 * @param array $args Optional. Overrides for the underlying query.
 * @return string
 */
function academia_library_course_filter( $args = array() ) {
	// Every rendering helper used below lives in the theme. Without it there
	// is nothing sensible to draw, so say so rather than fataling.
	if ( ! function_exists( 'academia_course_card' ) ) {
		return '';
	}

	$state = academia_library_filter_state();

	$query = wp_parse_args( $args, array(
		'number'   => 9,
		'columns'  => 3,
		'search'   => $state['search'],
		'category' => $state['category'],
		'level'    => $state['level'],
		'orderby'  => $state['sort'],
		'order'    => 'title' === $state['sort'] ? 'ASC' : 'DESC',
		'paged'    => $state['paged'],
	) );

	$result  = academia_get_courses( $query );
	$columns = max( 2, min( 4, (int) $query['columns'] ) );

	wp_enqueue_script(
		'academia-course-filter',
		academia_library_url() . 'assets/filter.js',
		array(),
		ACADEMIA_LIBRARY_VERSION,
		array( 'in_footer' => true, 'strategy' => 'defer' )
	);

	wp_enqueue_style(
		'academia-course-filter',
		academia_library_url() . 'assets/filter.css',
		array(),
		ACADEMIA_LIBRARY_VERSION
	);

	$out  = '<div class="academia-course-browser is-enhanceable" data-academia-browser>';
	$out .= academia_library_filter_form( $state );
	$out .= academia_library_results( $result, $columns, $query['paged'] );

	return $out . '</div>';
}

/**
 * The controls.
 *
 * A real <form> with a real submit button: that is what makes the no-JS path
 * work, and the script hides the button rather than the markup omitting it.
 *
 * @param array $state Filter state.
 * @return string
 */
function academia_library_filter_form( $state ) {
	$action = function_exists( 'academia_current_url' ) ? academia_current_url() : home_url( '/' );

	$out  = '<form class="academia-filter-form" method="get" action="' . esc_url( $action ) . '" data-academia-form>';
	$out .= '<div class="academia-filter">';

	$out .= '<div><label for="academia-course-search">' . esc_html__( 'Search', 'academia-library' ) . '</label>';
	$out .= '<input type="search" id="academia-course-search" name="course_search" value="' . esc_attr( $state['search'] ) . '" placeholder="' . esc_attr__( 'Course or subject', 'academia-library' ) . '"></div>';

	$categories = function_exists( 'academia_course_categories' ) ? academia_course_categories() : array();

	if ( $categories ) {
		$out .= '<div><label for="academia-course-cat">' . esc_html__( 'Subject', 'academia-library' ) . '</label>';
		$out .= '<select id="academia-course-cat" name="course_cat">';
		$out .= '<option value="">' . esc_html__( 'All subjects', 'academia-library' ) . '</option>';

		foreach ( $categories as $term ) {
			$out .= '<option value="' . esc_attr( $term->slug ) . '"' . selected( $state['category'], $term->slug, false ) . '>' . esc_html( $term->name ) . '</option>';
		}

		$out .= '</select></div>';
	}

	$levels = function_exists( 'academia_course_levels' ) ? academia_course_levels() : array();

	if ( $levels ) {
		$out .= '<div><label for="academia-course-level">' . esc_html__( 'Level', 'academia-library' ) . '</label>';
		$out .= '<select id="academia-course-level" name="course_level">';
		$out .= '<option value="">' . esc_html__( 'Any level', 'academia-library' ) . '</option>';

		foreach ( $levels as $slug => $label ) {
			$out .= '<option value="' . esc_attr( $slug ) . '"' . selected( $state['level'], $slug, false ) . '>' . esc_html( $label ) . '</option>';
		}

		$out .= '</select></div>';
	}

	$sorts = array(
		'date'   => __( 'Newest first', 'academia-library' ),
		'title'  => __( 'A to Z', 'academia-library' ),
		'price'  => __( 'Price', 'academia-library' ),
		'rating' => __( 'Best rated', 'academia-library' ),
	);

	$out .= '<div><label for="academia-course-sort">' . esc_html__( 'Sort by', 'academia-library' ) . '</label>';
	$out .= '<select id="academia-course-sort" name="course_sort">';

	foreach ( $sorts as $key => $label ) {
		$out .= '<option value="' . esc_attr( $key ) . '"' . selected( $state['sort'], $key, false ) . '>' . esc_html( $label ) . '</option>';
	}

	$out .= '</select></div>';
	$out .= '</div>';

	$out .= '<p class="academia-filter-submit"><button type="submit" class="wp-element-button">' . esc_html__( 'Apply filters', 'academia-library' ) . '</button></p>';

	return $out . '</form>';
}

/**
 * The results region — the part the script swaps.
 *
 * The count carries role="status" so a screen reader hears the new total after
 * a filter change, which is the only announcement a swap like this gets.
 *
 * @param array $result  Result from academia_get_courses().
 * @param int   $columns Column count.
 * @param int   $paged   Current page.
 * @return string
 */
function academia_library_results( $result, $columns, $paged ) {
	$total = (int) $result['total'];

	$out  = '<div class="academia-results" id="academia-results" data-academia-results aria-busy="false">';
	$out .= '<p class="academia-filter-count" role="status">' . esc_html( sprintf(
		/* translators: %s: number of courses. */
		_n( '%s course', '%s courses', $total, 'academia-library' ),
		number_format_i18n( $total )
	) ) . '</p>';

	if ( $result['items'] ) {
		$out .= '<div class="academia-grid-' . (int) $columns . ' academia-equal" style="gap:var(--wp--preset--spacing--40)">';

		foreach ( $result['items'] as $course ) {
			$out .= academia_course_card( $course );
		}

		$out .= '</div>';

		if ( function_exists( 'academia_course_pagination' ) ) {
			$out .= academia_course_pagination( $result, (int) $paged );
		}
	} elseif ( function_exists( 'academia_course_no_results' ) ) {
		$out .= academia_course_no_results();
	}

	return $out . '</div>';
}
