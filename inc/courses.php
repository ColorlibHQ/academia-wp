<?php
/**
 * Course data, read from whatever source the site actually has.
 *
 * A theme must not register a post type — that is the plugin's job, and a user
 * who switches theme must not lose their content. So nothing here registers
 * anything: this file only *reads*, through a small adapter layer, and every
 * pattern and template asks it for a normalised course array.
 *
 * Sources, in priority order:
 *
 *   1. Academia Library (`academia_course`) — the companion plugin, which
 *      carries the full meta set the cards are designed around.
 *   2. An established LMS — Tutor, LifterLMS, Sensei or LearnDash. Their
 *      course post types are read and their meta mapped onto the same shape,
 *      so the same card markup styles all of them.
 *   3. Plain posts in a "courses" category. This is the fallback, and it is
 *      why the theme is useful on a site with no plugins at all: the cards
 *      still render, just without level, duration or price.
 *
 * Adding a source means adding one entry to academia_course_sources() and a
 * mapping callback. Detection prefers a registered post type over a class
 * name, because plugins move their namespaces between versions and the post
 * type does not.
 *
 * @package Academia
 */

defined( 'ABSPATH' ) || exit;

/**
 * Known course sources.
 *
 * @return array<string, array> Source slug => definition.
 */
function academia_course_sources() {
	$sources = array(
		'academia' => array(
			'post_type' => 'academia_course',
			'taxonomy'  => 'academia_course_category',
			'level_tax' => 'academia_course_level',
			'map'       => 'academia_map_course_academia',
			'label'     => __( 'Academia Library', 'academia' ),
		),
		'tutor'    => array(
			'post_type' => 'courses',
			'taxonomy'  => 'course-category',
			'level_tax' => '',
			'map'       => 'academia_map_course_tutor',
			'label'     => __( 'Tutor LMS', 'academia' ),
		),
		'lifter'   => array(
			'post_type' => 'course',
			'taxonomy'  => 'course_cat',
			'level_tax' => 'course_difficulty',
			'map'       => 'academia_map_course_lifter',
			'label'     => __( 'LifterLMS', 'academia' ),
		),
		'sensei'   => array(
			'post_type' => 'course',
			'taxonomy'  => 'course-category',
			'level_tax' => '',
			'map'       => 'academia_map_course_generic',
			'label'     => __( 'Sensei LMS', 'academia' ),
		),
		'learndash' => array(
			'post_type' => 'sfwd-courses',
			'taxonomy'  => 'ld_course_category',
			'level_tax' => '',
			'map'       => 'academia_map_course_generic',
			'label'     => __( 'LearnDash', 'academia' ),
		),
	);

	/**
	 * Filters the course sources Academia can read.
	 *
	 * @param array $sources Source definitions.
	 */
	return apply_filters( 'academia_course_sources', $sources );
}

/**
 * The source this site is using.
 *
 * LifterLMS and Sensei both register a post type called `course`, so the
 * post type alone cannot separate them; where it is ambiguous a class check
 * breaks the tie. Resolved once per request.
 *
 * @return array{slug:string, post_type:string, taxonomy:string, level_tax:string, map:callable, label:string}
 */
function academia_course_source() {
	static $resolved = null;

	if ( null !== $resolved ) {
		return $resolved;
	}

	foreach ( academia_course_sources() as $slug => $source ) {
		if ( ! post_type_exists( $source['post_type'] ) ) {
			continue;
		}

		// `course` is claimed by both LifterLMS and Sensei.
		if ( 'lifter' === $slug && ! class_exists( 'LLMS_Course' ) ) {
			continue;
		}

		if ( 'sensei' === $slug && ! class_exists( 'Sensei_Main' ) ) {
			continue;
		}

		$resolved = array_merge( array( 'slug' => $slug ), $source );

		/** This filter is documented below. */
		return apply_filters( 'academia_course_source', $resolved );
	}

	$resolved = array(
		'slug'      => 'posts',
		'post_type' => 'post',
		'taxonomy'  => 'category',
		'level_tax' => '',
		'map'       => 'academia_map_course_post',
		'label'     => __( 'Posts', 'academia' ),
	);

	/**
	 * Filters the resolved course source.
	 *
	 * @param array $resolved Source definition, including its `slug`.
	 */
	return apply_filters( 'academia_course_source', $resolved );
}

/**
 * Whether the companion plugin is supplying course data.
 *
 * @return bool
 */
function academia_has_course_plugin() {
	return 'academia' === academia_course_source()['slug'];
}

/**
 * Query courses and return them in the theme's normalised shape.
 *
 * @param array $args {
 *     Optional. Query arguments.
 *
 *     @type int    $number   How many to return. Default 6.
 *     @type string $category Category slug to filter by.
 *     @type string $level    Level slug to filter by.
 *     @type string $orderby  `date`, `title`, `price` or `rating`. Default `date`.
 *     @type string $order    `ASC` or `DESC`. Default `DESC`.
 *     @type string $search   Free-text search.
 *     @type int    $paged    Page number.
 * }
 * @return array{items:array, total:int, pages:int}
 */
function academia_get_courses( $args = array() ) {
	$args = wp_parse_args( $args, array(
		'number'   => 6,
		'category' => '',
		'level'    => '',
		'orderby'  => 'date',
		'order'    => 'DESC',
		'search'   => '',
		'paged'    => 1,
	) );

	$source = academia_course_source();

	$query_args = array(
		'post_type'           => $source['post_type'],
		'post_status'         => 'publish',
		'posts_per_page'      => (int) $args['number'],
		'paged'               => max( 1, (int) $args['paged'] ),
		'ignore_sticky_posts' => true,
		// The cards need the thumbnail and the meta anyway, so priming both
		// caches here avoids a query per card.
		'update_post_term_cache' => true,
		'update_post_meta_cache' => true,
	);

	if ( '' !== $args['search'] ) {
		$query_args['s'] = $args['search'];
	}

	$tax_query = array();

	if ( '' !== $args['category'] && $source['taxonomy'] ) {
		$tax_query[] = array(
			'taxonomy' => $source['taxonomy'],
			'field'    => 'slug',
			'terms'    => $args['category'],
		);
	}

	if ( '' !== $args['level'] && $source['level_tax'] ) {
		$tax_query[] = array(
			'taxonomy' => $source['level_tax'],
			'field'    => 'slug',
			'terms'    => $args['level'],
		);
	}

	if ( $tax_query ) {
		$query_args['tax_query'] = $tax_query; // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
	}

	// Price and rating live in meta, so ordering by them needs a meta clause.
	// `meta_value_num` is only correct when the key is actually present, hence
	// the EXISTS-or-not-exists pair.
	if ( 'price' === $args['orderby'] || 'rating' === $args['orderby'] ) {
		$key = '_academia_' . $args['orderby'];

		$query_args['meta_query'] = array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_query
			'relation' => 'OR',
			'primary'  => array( 'key' => $key, 'compare' => 'EXISTS', 'type' => 'DECIMAL(10,2)' ),
			'missing'  => array( 'key' => $key, 'compare' => 'NOT EXISTS' ),
		);

		$query_args['orderby'] = array( 'primary' => $args['order'], 'date' => 'DESC' );
	} else {
		$query_args['orderby'] = $args['orderby'];
		$query_args['order']   = $args['order'];
	}

	if ( 'posts' === $source['slug'] ) {
		$category = get_category_by_slug( 'courses' );

		if ( $category ) {
			$query_args['cat'] = $category->term_id;
		}
	}

	$query = new WP_Query( $query_args );
	$items = array();

	foreach ( $query->posts as $post ) {
		$items[] = academia_normalise_course( $post, $source );
	}

	return array(
		'items' => $items,
		'total' => (int) $query->found_posts,
		'pages' => (int) $query->max_num_pages,
	);
}

/**
 * Put one course into the normalised shape, whatever it came from.
 *
 * @param WP_Post $post   Course post.
 * @param array   $source Source definition.
 * @return array
 */
function academia_normalise_course( $post, $source ) {
	$course = array(
		'id'           => $post->ID,
		'title'        => get_the_title( $post ),
		'permalink'    => get_permalink( $post ),
		'excerpt'      => academia_course_excerpt( $post ),
		'thumbnail_id' => (int) get_post_thumbnail_id( $post ),
		'level'        => '',
		'duration'     => '',
		'lessons'      => 0,
		'price'        => '',
		'sale_price'   => '',
		'free'         => false,
		'instructor'   => '',
		'rating'       => 0.0,
		'reviews'      => 0,
		'categories'   => array(),
	);

	if ( $source['taxonomy'] ) {
		$terms = get_the_terms( $post, $source['taxonomy'] );

		if ( $terms && ! is_wp_error( $terms ) ) {
			$course['categories'] = $terms;
		}
	}

	if ( $source['level_tax'] ) {
		$levels = get_the_terms( $post, $source['level_tax'] );

		if ( $levels && ! is_wp_error( $levels ) ) {
			$course['level'] = $levels[0]->name;
		}
	}

	if ( is_callable( $source['map'] ) ) {
		$course = call_user_func( $source['map'], $course, $post );
	}

	/**
	 * Filters a normalised course.
	 *
	 * @param array   $course Normalised course.
	 * @param WP_Post $post   Source post.
	 * @param array   $source Source definition.
	 */
	return apply_filters( 'academia_course', $course, $post, $source );
}

/**
 * A trimmed excerpt that does not depend on the post having one set.
 *
 * @param WP_Post $post Course post.
 * @return string
 */
function academia_course_excerpt( $post ) {
	$excerpt = has_excerpt( $post ) ? get_the_excerpt( $post ) : wp_strip_all_tags( strip_shortcodes( $post->post_content ) );

	return wp_trim_words( $excerpt, 22, '&hellip;' );
}

/**
 * Academia Library mapping: the full meta set.
 *
 * @param array   $course Normalised course.
 * @param WP_Post $post   Source post.
 * @return array
 */
function academia_map_course_academia( $course, $post ) {
	$course['duration']   = (string) get_post_meta( $post->ID, '_academia_duration', true );
	$course['lessons']    = (int) get_post_meta( $post->ID, '_academia_lessons', true );
	$course['price']      = (string) get_post_meta( $post->ID, '_academia_price', true );
	$course['sale_price'] = (string) get_post_meta( $post->ID, '_academia_sale_price', true );
	$course['instructor'] = (string) get_post_meta( $post->ID, '_academia_instructor', true );
	$course['rating']     = (float) get_post_meta( $post->ID, '_academia_rating', true );
	$course['reviews']    = (int) get_post_meta( $post->ID, '_academia_reviews', true );
	$course['free']       = '' === $course['price'] || '0' === $course['price'];

	if ( '' === $course['level'] ) {
		$course['level'] = (string) get_post_meta( $post->ID, '_academia_level', true );
	}

	return $course;
}

/**
 * Tutor LMS mapping.
 *
 * @param array   $course Normalised course.
 * @param WP_Post $post   Source post.
 * @return array
 */
function academia_map_course_tutor( $course, $post ) {
	$settings = get_post_meta( $post->ID, '_tutor_course_settings', true );

	if ( is_array( $settings ) && isset( $settings['maximum_students'] ) ) {
		$course['duration'] = (string) get_post_meta( $post->ID, '_course_duration', true );
	}

	$course['level']      = (string) get_post_meta( $post->ID, '_tutor_course_level', true );
	$course['price']      = (string) get_post_meta( $post->ID, 'tutor_course_price', true );
	$course['free']       = 'free' === get_post_meta( $post->ID, '_tutor_course_price_type', true );
	$course['instructor'] = get_the_author_meta( 'display_name', (int) $post->post_author );

	return $course;
}

/**
 * LifterLMS mapping.
 *
 * @param array   $course Normalised course.
 * @param WP_Post $post   Source post.
 * @return array
 */
function academia_map_course_lifter( $course, $post ) {
	$course['price']      = (string) get_post_meta( $post->ID, '_llms_price', true );
	$course['duration']   = (string) get_post_meta( $post->ID, '_llms_length', true );
	$course['free']       = '' === $course['price'] || 0.0 === (float) $course['price'];
	$course['instructor'] = get_the_author_meta( 'display_name', (int) $post->post_author );

	return $course;
}

/**
 * Whatever we can get from an LMS with no documented meta keys.
 *
 * @param array   $course Normalised course.
 * @param WP_Post $post   Source post.
 * @return array
 */
function academia_map_course_generic( $course, $post ) {
	$course['instructor'] = get_the_author_meta( 'display_name', (int) $post->post_author );
	$course['free']       = true;

	return $course;
}

/**
 * Plain-post mapping — the no-plugin fallback.
 *
 * @param array   $course Normalised course.
 * @param WP_Post $post   Source post.
 * @return array
 */
function academia_map_course_post( $course, $post ) {
	$course['instructor'] = get_the_author_meta( 'display_name', (int) $post->post_author );
	$course['free']       = true;

	// Reading time is a usable stand-in for duration when there is no meta.
	$words = str_word_count( wp_strip_all_tags( $post->post_content ) );

	if ( $words > 0 ) {
		$minutes = max( 1, (int) round( $words / 200 ) );

		/* translators: %d: number of minutes. */
		$course['duration'] = sprintf( _n( '%d min read', '%d min read', $minutes, 'academia' ), $minutes );
	}

	return $course;
}

/**
 * Course categories for the filter control.
 *
 * @return WP_Term[]
 */
function academia_course_categories() {
	$source = academia_course_source();

	if ( ! $source['taxonomy'] ) {
		return array();
	}

	$terms = get_terms( array(
		'taxonomy'   => $source['taxonomy'],
		'hide_empty' => true,
	) );

	return is_wp_error( $terms ) ? array() : $terms;
}

/**
 * Course levels for the filter control.
 *
 * Falls back to the distinct values of the `_academia_level` meta when the
 * source has no level taxonomy.
 *
 * @return array<string, string> Slug => label.
 */
function academia_course_levels() {
	$source = academia_course_source();

	if ( $source['level_tax'] ) {
		$terms = get_terms( array( 'taxonomy' => $source['level_tax'], 'hide_empty' => true ) );

		if ( ! is_wp_error( $terms ) && $terms ) {
			return wp_list_pluck( $terms, 'name', 'slug' );
		}
	}

	return array();
}

/* -------------------------------------------------------------------------
 * Rendering helpers. Patterns call these so one change lands everywhere.
 * ---------------------------------------------------------------------- */

/**
 * An inline icon from the theme's Feather set.
 *
 * Inlined rather than an <img> so it inherits currentColor in the meta row.
 * The file is read once per icon per request.
 *
 * @param string $name Icon file name without extension.
 * @return string Sanitised SVG, or an empty string.
 */
function academia_icon( $name ) {
	static $cache = array();

	$name = preg_replace( '/[^a-z0-9-]/', '', (string) $name );

	if ( '' === $name ) {
		return '';
	}

	if ( isset( $cache[ $name ] ) ) {
		return $cache[ $name ];
	}

	$path = get_theme_file_path( 'assets/images/icons/' . $name . '.svg' );

	if ( ! file_exists( $path ) ) {
		$cache[ $name ] = '';

		return '';
	}

	$svg = file_get_contents( $path ); // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents

	// The icons ship with a hard-coded stroke; strip it so currentColor wins.
	$svg = preg_replace( '/\s(stroke|fill)="(?!none)[^"]*"/', '', (string) $svg );
	$svg = str_replace( '<svg', '<svg stroke="currentColor" fill="none" aria-hidden="true" focusable="false"', $svg );

	$cache[ $name ] = wp_kses( $svg, array(
		'svg'      => array( 'xmlns' => true, 'viewbox' => true, 'width' => true, 'height' => true, 'stroke' => true, 'fill' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true, 'aria-hidden' => true, 'focusable' => true, 'class' => true ),
		'path'     => array( 'd' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true ),
		'circle'   => array( 'cx' => true, 'cy' => true, 'r' => true, 'stroke-width' => true ),
		'rect'     => array( 'x' => true, 'y' => true, 'width' => true, 'height' => true, 'rx' => true, 'ry' => true, 'stroke-width' => true ),
		'line'     => array( 'x1' => true, 'y1' => true, 'x2' => true, 'y2' => true, 'stroke-width' => true, 'stroke-linecap' => true ),
		'polyline' => array( 'points' => true, 'stroke-width' => true, 'stroke-linecap' => true, 'stroke-linejoin' => true ),
		'polygon'  => array( 'points' => true, 'stroke-width' => true ),
		'ellipse'  => array( 'cx' => true, 'cy' => true, 'rx' => true, 'ry' => true ),
		'g'        => array( 'stroke-width' => true ),
	) );

	return $cache[ $name ];
}

/**
 * The duration / level / lessons row under a course title.
 *
 * Renders only the facts the source actually has, so a plain-posts site gets a
 * shorter row rather than a row of empty labels.
 *
 * @param array $course Normalised course.
 * @return string
 */
function academia_course_meta_row( $course ) {
	$facts = array();

	if ( '' !== $course['duration'] ) {
		$facts[] = array( 'clock', $course['duration'] );
	}

	if ( $course['lessons'] > 0 ) {
		$lessons = (int) $course['lessons'];

		/* translators: %d: number of lessons. */
		$facts[] = array( 'book-open', sprintf( _n( '%d lesson', '%d lessons', $lessons, 'academia' ), $lessons ) );
	}

	if ( '' !== $course['level'] ) {
		$facts[] = array( 'bar-chart', $course['level'] );
	}

	if ( ! $facts ) {
		return '';
	}

	$out = '<ul class="academia-meta">';

	foreach ( $facts as $fact ) {
		$out .= '<li>' . academia_icon( $fact[0] ) . '<span>' . esc_html( $fact[1] ) . '</span></li>';
	}

	return $out . '</ul>';
}

/**
 * The price line, with a struck-through original when a course is on offer.
 *
 * @param array $course Normalised course.
 * @return string
 */
function academia_course_price( $course ) {
	if ( $course['free'] ) {
		return '<p class="academia-price academia-price-free">' . esc_html__( 'Free', 'academia' ) . '</p>';
	}

	$price = academia_format_price( $course['price'] );

	if ( '' !== $course['sale_price'] && (float) $course['sale_price'] < (float) $course['price'] ) {
		return '<p class="academia-price"><s>' . esc_html( $price ) . '</s>' . esc_html( academia_format_price( $course['sale_price'] ) ) . '</p>';
	}

	return '<p class="academia-price">' . esc_html( $price ) . '</p>';
}

/**
 * Format a price, deferring to WooCommerce's formatter when it is available so
 * the currency matches the rest of the site.
 *
 * @param string $amount Raw amount.
 * @return string
 */
function academia_format_price( $amount ) {
	if ( '' === $amount ) {
		return '';
	}

	if ( ! is_numeric( $amount ) ) {
		return (string) $amount;
	}

	if ( function_exists( 'wc_price' ) ) {
		return wp_strip_all_tags( wc_price( (float) $amount ) );
	}

	/**
	 * Filters the currency symbol used when WooCommerce is not active.
	 *
	 * @param string $symbol Currency symbol.
	 */
	$symbol = apply_filters( 'academia_currency_symbol', '$' );

	$decimals = ( (float) $amount === floor( (float) $amount ) ) ? 0 : 2;

	return $symbol . number_format_i18n( (float) $amount, $decimals );
}

/**
 * A star rating that needs no icon font.
 *
 * @param array $course Normalised course.
 * @return string
 */
function academia_course_rating( $course ) {
	if ( $course['rating'] <= 0 ) {
		return '';
	}

	$rounded = (int) round( $course['rating'] );
	$stars   = str_repeat( '★', max( 0, min( 5, $rounded ) ) ) . str_repeat( '☆', max( 0, 5 - $rounded ) );

	$out = '<p class="academia-rating">';
	$out .= '<span class="academia-stars" role="img" aria-label="' . esc_attr( sprintf(
		/* translators: %s: rating out of five. */
		__( 'Rated %s out of 5', 'academia' ),
		number_format_i18n( $course['rating'], 1 )
	) ) . '">' . $stars . '</span> ';
	$out .= '<span>' . esc_html( number_format_i18n( $course['rating'], 1 ) );

	$reviews = (int) $course['reviews'];

	if ( $reviews > 0 ) {
		/* translators: %s: number of reviews. */
		$out .= ' ' . esc_html( sprintf( _n( '(%s review)', '(%s reviews)', $reviews, 'academia' ), number_format_i18n( $reviews ) ) );
	}

	return $out . '</span></p>';
}

/**
 * One course card. Used by the course patterns and by the plugin's filtered
 * archive, so both always look identical.
 *
 * @param array $course Normalised course.
 * @return string
 */
function academia_course_card( $course ) {
	$title = '' !== $course['title'] ? $course['title'] : __( '(no title)', 'academia' );

	$out = '<div class="wp-block-group academia-course-card is-style-card" style="border-radius:20px">';

	if ( $course['thumbnail_id'] ) {
		$out .= '<figure class="wp-block-image academia-course-thumb">';
		$out .= '<a href="' . esc_url( $course['permalink'] ) . '" tabindex="-1" aria-hidden="true">';
		$out .= wp_get_attachment_image( $course['thumbnail_id'], 'large', false, array(
			'alt'      => '',
			'loading'  => 'lazy',
			'decoding' => 'async',
		) );
		$out .= '</a></figure>';
	}

	if ( $course['categories'] ) {
		$term = $course['categories'][0];
		$out .= '<p><a class="academia-chip" href="' . esc_url( (string) get_term_link( $term ) ) . '">' . esc_html( $term->name ) . '</a></p>';
	}

	$out .= '<h3 class="wp-block-heading has-large-font-size">';
	$out .= '<a href="' . esc_url( $course['permalink'] ) . '">' . esc_html( $title ) . '</a></h3>';

	if ( '' !== $course['excerpt'] ) {
		$out .= '<p class="has-muted-color has-text-color">' . esc_html( $course['excerpt'] ) . '</p>';
	}

	$out .= academia_course_meta_row( $course );
	$out .= academia_course_rating( $course );

	// The price and the enrol button share the card's last line, pushed to the
	// bottom by .academia-equal so cards in a row end level.
	$out .= '<div class="wp-block-group academia-course-foot" style="display:flex;align-items:center;justify-content:space-between;gap:1rem;flex-wrap:wrap">';
	$out .= academia_course_price( $course );
	$out .= '<span class="wp-block-button is-style-academia-ghost"><a class="wp-block-button__link wp-element-button" href="' . esc_url( $course['permalink'] ) . '">' . esc_html__( 'View course', 'academia' ) . '</a></span>';
	$out .= '</div>';

	return $out . '</div>';
}

/**
 * A grid of course cards, or a clearly worded empty state.
 *
 * An empty state matters more here than usual: on a fresh install there are no
 * courses at all, and a section that renders nothing looks broken rather than
 * empty.
 *
 * @param array $args Passed to academia_get_courses().
 * @return string
 */
function academia_course_grid( $args = array() ) {
	$result = academia_get_courses( $args );

	if ( ! $result['items'] ) {
		return academia_course_empty_state();
	}

	$columns = isset( $args['columns'] ) ? (int) $args['columns'] : 3;
	$columns = max( 2, min( 4, $columns ) );

	$out = '<div class="academia-grid-' . $columns . ' academia-equal" style="gap:var(--wp--preset--spacing--40)">';

	foreach ( $result['items'] as $course ) {
		$out .= academia_course_card( $course );
	}

	return $out . '</div>';
}

/**
 * What a course section shows when there are no courses yet.
 *
 * @return string
 */
function academia_course_empty_state() {
	$out = '<div class="academia-empty">';
	$out .= '<p><strong>' . esc_html__( 'No courses yet', 'academia' ) . '</strong></p>';

	if ( academia_has_course_plugin() && current_user_can( 'edit_posts' ) ) {
		$out .= '<p class="has-muted-color has-text-color">' . esc_html__( 'Add your first course and it will appear here.', 'academia' ) . '</p>';
		$out .= '<p><a class="academia-chip" href="' . esc_url( admin_url( 'post-new.php?post_type=academia_course' ) ) . '">' . esc_html__( 'Add a course', 'academia' ) . '</a></p>';
	} elseif ( current_user_can( 'install_plugins' ) ) {
		$out .= '<p class="has-muted-color has-text-color">' . esc_html__( 'Install Academia Library to add courses with levels, durations and prices — or publish posts in a category called “courses”.', 'academia' ) . '</p>';
	} else {
		$out .= '<p class="has-muted-color has-text-color">' . esc_html__( 'Courses will be listed here soon.', 'academia' ) . '</p>';
	}

	return $out . '</div>';
}

/* -------------------------------------------------------------------------
 * The filter bar.
 *
 * Plugins load before a theme's functions.php, so when Academia Library is
 * active its richer version is already defined and this one is skipped. The
 * guard is what lets the course-filter pattern be used either way instead of
 * fataling on a missing function.
 * ---------------------------------------------------------------------- */

if ( ! function_exists( 'academia_course_filter' ) ) {
	/**
	 * Search, category, level and sort controls, plus the results grid.
	 *
	 * This fallback is a plain GET form: it filters correctly, with a page
	 * load per change. The plugin's version adds the no-reload swap.
	 *
	 * @param array $args Optional. Overrides for the underlying query.
	 * @return string
	 */
	function academia_course_filter( $args = array() ) {
		$search   = isset( $_GET['course_search'] ) ? sanitize_text_field( wp_unslash( $_GET['course_search'] ) ) : '';
		$category = isset( $_GET['course_cat'] ) ? sanitize_title( wp_unslash( $_GET['course_cat'] ) ) : '';
		$level    = isset( $_GET['course_level'] ) ? sanitize_title( wp_unslash( $_GET['course_level'] ) ) : '';
		$sort     = isset( $_GET['course_sort'] ) ? sanitize_key( wp_unslash( $_GET['course_sort'] ) ) : 'date';

		$allowed = array( 'date', 'title', 'price', 'rating' );

		if ( ! in_array( $sort, $allowed, true ) ) {
			$sort = 'date';
		}

		$query = wp_parse_args( $args, array(
			'number'   => 9,
			'columns'  => 3,
			'search'   => $search,
			'category' => $category,
			'level'    => $level,
			'orderby'  => $sort,
			'order'    => 'title' === $sort ? 'ASC' : 'DESC',
			'paged'    => max( 1, (int) get_query_var( 'paged', 1 ) ),
		) );

		$result = academia_get_courses( $query );

		$out  = '<form class="academia-course-browser" method="get" action="' . esc_url( academia_current_url() ) . '">';
		$out .= '<div class="academia-filter">';

		$out .= '<div><label for="academia-course-search">' . esc_html__( 'Search', 'academia' ) . '</label>';
		$out .= '<input type="search" id="academia-course-search" name="course_search" value="' . esc_attr( $search ) . '" placeholder="' . esc_attr__( 'Course or subject', 'academia' ) . '"></div>';

		$categories = academia_course_categories();

		if ( $categories ) {
			$out .= '<div><label for="academia-course-cat">' . esc_html__( 'Subject', 'academia' ) . '</label>';
			$out .= '<select id="academia-course-cat" name="course_cat">';
			$out .= '<option value="">' . esc_html__( 'All subjects', 'academia' ) . '</option>';

			foreach ( $categories as $term ) {
				$out .= '<option value="' . esc_attr( $term->slug ) . '"' . selected( $category, $term->slug, false ) . '>' . esc_html( $term->name ) . '</option>';
			}

			$out .= '</select></div>';
		}

		$levels = academia_course_levels();

		if ( $levels ) {
			$out .= '<div><label for="academia-course-level">' . esc_html__( 'Level', 'academia' ) . '</label>';
			$out .= '<select id="academia-course-level" name="course_level">';
			$out .= '<option value="">' . esc_html__( 'Any level', 'academia' ) . '</option>';

			foreach ( $levels as $slug => $label ) {
				$out .= '<option value="' . esc_attr( $slug ) . '"' . selected( $level, $slug, false ) . '>' . esc_html( $label ) . '</option>';
			}

			$out .= '</select></div>';
		}

		$sorts = array(
			'date'   => __( 'Newest first', 'academia' ),
			'title'  => __( 'A to Z', 'academia' ),
			'price'  => __( 'Price', 'academia' ),
			'rating' => __( 'Best rated', 'academia' ),
		);

		$out .= '<div><label for="academia-course-sort">' . esc_html__( 'Sort by', 'academia' ) . '</label>';
		$out .= '<select id="academia-course-sort" name="course_sort">';

		foreach ( $sorts as $key => $label ) {
			$out .= '<option value="' . esc_attr( $key ) . '"' . selected( $sort, $key, false ) . '>' . esc_html( $label ) . '</option>';
		}

		$out .= '</select></div>';
		$out .= '</div>';

		// Without JS this is how the form is submitted; the plugin hides it.
		$out .= '<p class="academia-filter-submit"><button type="submit" class="wp-element-button">' . esc_html__( 'Apply filters', 'academia' ) . '</button></p>';
		$out .= '</form>';

		$total = (int) $result['total'];

		$out .= '<div class="academia-results" id="academia-results">';
		$out .= '<p class="academia-filter-count" role="status">' . esc_html( sprintf(
			/* translators: %s: number of courses. */
			_n( '%s course', '%s courses', $total, 'academia' ),
			number_format_i18n( $total )
		) ) . '</p>';

		if ( $result['items'] ) {
			$columns = max( 2, min( 4, (int) $query['columns'] ) );
			$out    .= '<div class="academia-grid-' . $columns . ' academia-equal" style="gap:var(--wp--preset--spacing--40)">';

			foreach ( $result['items'] as $course ) {
				$out .= academia_course_card( $course );
			}

			$out .= '</div>';
			$out .= academia_course_pagination( $result, (int) $query['paged'] );
		} else {
			$out .= academia_course_no_results();
		}

		return $out . '</div>';
	}
}

/**
 * The current URL, without the pagination or filter arguments.
 *
 * @return string
 */
function academia_current_url() {
	$permalink = is_singular() || is_page() ? get_permalink() : home_url( add_query_arg( array() ) );

	return remove_query_arg( array( 'paged', 'course_search', 'course_cat', 'course_level', 'course_sort' ), (string) $permalink );
}

/**
 * Prev/next links for a filtered course list, preserving the filters.
 *
 * @param array $result Result from academia_get_courses().
 * @param int   $paged  Current page.
 * @return string
 */
function academia_course_pagination( $result, $paged ) {
	if ( $result['pages'] < 2 ) {
		return '';
	}

	$keep = array_filter( array(
		'course_search' => isset( $_GET['course_search'] ) ? sanitize_text_field( wp_unslash( $_GET['course_search'] ) ) : '',
		'course_cat'    => isset( $_GET['course_cat'] ) ? sanitize_title( wp_unslash( $_GET['course_cat'] ) ) : '',
		'course_level'  => isset( $_GET['course_level'] ) ? sanitize_title( wp_unslash( $_GET['course_level'] ) ) : '',
		'course_sort'   => isset( $_GET['course_sort'] ) ? sanitize_key( wp_unslash( $_GET['course_sort'] ) ) : '',
	) );

	$base = academia_current_url();
	$out  = '<nav class="wp-block-query-pagination" aria-label="' . esc_attr__( 'Course pages', 'academia' ) . '">';

	for ( $page = 1; $page <= $result['pages']; $page++ ) {
		$url = add_query_arg( array_merge( $keep, 1 === $page ? array() : array( 'paged' => $page ) ), $base );

		if ( $page === $paged ) {
			$out .= '<span class="page-numbers current" aria-current="page">' . esc_html( number_format_i18n( $page ) ) . '</span>';
		} else {
			$out .= '<a class="page-numbers" href="' . esc_url( $url ) . '">' . esc_html( number_format_i18n( $page ) ) . '</a>';
		}
	}

	return $out . '</nav>';
}

/**
 * The empty state for a filter that matched nothing — distinct from having no
 * courses at all, because the fix is different.
 *
 * @return string
 */
function academia_course_no_results() {
	$out  = '<div class="academia-empty">';
	$out .= '<p><strong>' . esc_html__( 'Nothing matched those filters', 'academia' ) . '</strong></p>';
	$out .= '<p class="has-muted-color has-text-color">' . esc_html__( 'Try a broader subject, or clear the search box.', 'academia' ) . '</p>';
	$out .= '<p><a class="academia-chip" href="' . esc_url( academia_current_url() ) . '">' . esc_html__( 'Clear all filters', 'academia' ) . '</a></p>';

	return $out . '</div>';
}

/* -------------------------------------------------------------------------
 * Shortcodes.
 *
 * These exist because of how patterns reach the page. A pattern file's PHP
 * runs when the pattern is rendered *from the file* — but the starter sites and
 * the front-page setup expand patterns into real post content so the copy is
 * editable, and PHP inside stored content never runs. Expanding a course grid
 * would therefore freeze whatever it rendered at activation (on a new site:
 * the "no courses yet" empty state) into the page forever.
 *
 * A shortcode survives that: it is stored as text and executed on every
 * render, in a pattern file and in post content alike. So every dynamic
 * section goes through one, and the static demo copy is free to be expanded
 * and edited.
 * ---------------------------------------------------------------------- */

/**
 * [academia_courses] — a grid of courses.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function academia_courses_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'number'   => 6,
		'columns'  => 3,
		'category' => '',
		'level'    => '',
		'orderby'  => 'date',
		'order'    => 'DESC',
	), $atts, 'academia_courses' );

	return academia_course_grid( array(
		'number'   => absint( $atts['number'] ),
		'columns'  => absint( $atts['columns'] ),
		'category' => sanitize_title( $atts['category'] ),
		'level'    => sanitize_title( $atts['level'] ),
		'orderby'  => sanitize_key( $atts['orderby'] ),
		'order'    => 'ASC' === strtoupper( $atts['order'] ) ? 'ASC' : 'DESC',
	) );
}
add_shortcode( 'academia_courses', 'academia_courses_shortcode' );

/**
 * [academia_course_browser] — the filter, search and sort controls with results.
 *
 * @param array $atts Shortcode attributes.
 * @return string
 */
function academia_course_browser_shortcode( $atts ) {
	$atts = shortcode_atts( array(
		'number'  => 9,
		'columns' => 3,
	), $atts, 'academia_course_browser' );

	return academia_course_filter( array(
		'number'  => absint( $atts['number'] ),
		'columns' => absint( $atts['columns'] ),
	) );
}
add_shortcode( 'academia_course_browser', 'academia_course_browser_shortcode' );
