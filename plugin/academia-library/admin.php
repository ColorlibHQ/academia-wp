<?php
/**
 * The course details panel.
 *
 * A classic meta box rather than a React sidebar plugin: the fields are eight
 * plain inputs, and a meta box needs no build step, works in the classic
 * editor, and cannot break when the editor's JS API changes. The meta is
 * registered with `show_in_rest` regardless, so the REST API and the Block
 * Bindings API see the same values.
 *
 * @package Academia_Library
 */

defined( 'ABSPATH' ) || exit;

/**
 * Register the panel.
 */
function academia_library_meta_box() {
	add_meta_box(
		'academia-course-details',
		__( 'Course details', 'academia-library' ),
		'academia_library_render_meta_box',
		'academia_course',
		'side',
		'high'
	);
}
add_action( 'add_meta_boxes', 'academia_library_meta_box' );

/**
 * Render the panel.
 *
 * @param WP_Post $post Course being edited.
 */
function academia_library_render_meta_box( $post ) {
	wp_nonce_field( 'academia_course_details', 'academia_course_nonce' );

	echo '<div class="academia-course-fields">';

	foreach ( academia_library_fields() as $key => $field ) {
		$value = get_post_meta( $post->ID, $key, true );
		$id    = 'academia-field-' . sanitize_key( $key );

		$type = 'text';
		$step = '';

		if ( 'integer' === $field['type'] ) {
			$type = 'number';
			$step = ' step="1" min="0"';
		} elseif ( 'number' === $field['type'] ) {
			$type = 'number';
			$step = ' step="0.1" min="0" max="5"';
		}

		echo '<p style="margin-bottom:14px">';
		echo '<label for="' . esc_attr( $id ) . '"><strong>' . esc_html( $field['label'] ) . '</strong></label>';
		echo '<input type="' . esc_attr( $type ) . '"' . $step . ' id="' . esc_attr( $id ) . '" name="' . esc_attr( $key ) . '" value="' . esc_attr( (string) $value ) . '" class="widefat" style="margin-top:4px">'; // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- $step is a literal above.
		echo '<span class="description" style="display:block;margin-top:4px">' . esc_html( $field['hint'] ) . '</span>';
		echo '</p>';
	}

	echo '</div>';
}

/**
 * Save the panel.
 *
 * Each value goes through the same sanitize callback the meta was registered
 * with, so the REST route and this form cannot disagree about what is valid.
 *
 * @param int     $post_id Course ID.
 * @param WP_Post $post    Course.
 */
function academia_library_save_meta( $post_id, $post ) {
	if ( 'academia_course' !== $post->post_type ) {
		return;
	}

	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}

	// The block editor saves meta over REST, where this form is absent. Bailing
	// on a missing nonce is what stops that path from wiping every field.
	if ( ! isset( $_POST['academia_course_nonce'] ) ) {
		return;
	}

	if ( ! wp_verify_nonce( sanitize_key( wp_unslash( $_POST['academia_course_nonce'] ) ), 'academia_course_details' ) ) {
		return;
	}

	if ( ! current_user_can( 'edit_post', $post_id ) ) {
		return;
	}

	foreach ( academia_library_fields() as $key => $field ) {
		if ( ! isset( $_POST[ $key ] ) ) {
			continue;
		}

		$raw   = wp_unslash( $_POST[ $key ] ); // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- sanitized on the next line.
		$value = call_user_func( $field['sanitize'], $raw );

		if ( '' === $value || null === $value ) {
			delete_post_meta( $post_id, $key );
		} else {
			update_post_meta( $post_id, $key, $value );
		}
	}
}
add_action( 'save_post', 'academia_library_save_meta', 10, 2 );

/**
 * Show the facts that matter in the courses list, so a catalogue can be
 * checked at a glance instead of opening every course.
 *
 * @param array $columns Existing columns.
 * @return array
 */
function academia_library_columns( $columns ) {
	$insert = array(
		'academia_level'    => __( 'Level', 'academia-library' ),
		'academia_duration' => __( 'Duration', 'academia-library' ),
		'academia_price'    => __( 'Price', 'academia-library' ),
	);

	// Keep the date column last.
	$date = isset( $columns['date'] ) ? array( 'date' => $columns['date'] ) : array();
	unset( $columns['date'] );

	return array_merge( $columns, $insert, $date );
}
add_filter( 'manage_academia_course_posts_columns', 'academia_library_columns' );

/**
 * Fill those columns.
 *
 * @param string $column  Column key.
 * @param int    $post_id Course ID.
 */
function academia_library_column_content( $column, $post_id ) {
	if ( 'academia_level' === $column ) {
		$terms = get_the_terms( $post_id, 'academia_course_level' );
		$level = ( $terms && ! is_wp_error( $terms ) ) ? $terms[0]->name : get_post_meta( $post_id, '_academia_level', true );

		echo esc_html( '' !== $level ? $level : '—' );

		return;
	}

	if ( 'academia_duration' === $column ) {
		$duration = get_post_meta( $post_id, '_academia_duration', true );

		echo esc_html( '' !== $duration ? $duration : '—' );

		return;
	}

	if ( 'academia_price' === $column ) {
		$price = get_post_meta( $post_id, '_academia_price', true );

		if ( '' === $price ) {
			esc_html_e( 'Free', 'academia-library' );

			return;
		}

		echo esc_html( function_exists( 'academia_format_price' ) ? academia_format_price( $price ) : $price );
	}
}
add_action( 'manage_academia_course_posts_custom_column', 'academia_library_column_content', 10, 2 );

/**
 * Make Level and Price sortable.
 *
 * @param array $columns Sortable columns.
 * @return array
 */
function academia_library_sortable( $columns ) {
	$columns['academia_price'] = 'academia_price';

	return $columns;
}
add_filter( 'manage_edit-academia_course_sortable_columns', 'academia_library_sortable' );

/**
 * Order by price when that column is clicked.
 *
 * @param WP_Query $query Current query.
 */
function academia_library_sort_query( $query ) {
	if ( ! is_admin() || ! $query->is_main_query() ) {
		return;
	}

	if ( 'academia_price' !== $query->get( 'orderby' ) ) {
		return;
	}

	$query->set( 'meta_key', '_academia_price' );
	$query->set( 'orderby', 'meta_value_num' );
}
add_action( 'pre_get_posts', 'academia_library_sort_query' );
