<?php
/**
 * Plugin Name: Academia Library
 * Plugin URI: https://colorlib.com/wp/themes/academia/
 * Description: Adds a Course content type to the Academia theme — levels, durations, lesson counts, prices, instructors and ratings — plus a course browser that filters and sorts without reloading the page. Course content stays in your database if you change theme.
 * Version: 1.0.0
 * Requires at least: 6.6
 * Requires PHP: 7.4
 * Author: Colorlib
 * Author URI: https://colorlib.com/
 * Update URI: https://updates.colorlib.com/plugin/academia-library.json
 * Text Domain: academia-library
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 *
 * @package Academia_Library
 */

defined( 'ABSPATH' ) || exit;

const ACADEMIA_LIBRARY_VERSION = '1.0.0';

/**
 * Where the plugin's own files live.
 *
 * @return string
 */
function academia_library_path() {
	return plugin_dir_path( __FILE__ );
}

/**
 * Public URL for the plugin's own files.
 *
 * @return string
 */
function academia_library_url() {
	return plugin_dir_url( __FILE__ );
}

/* -------------------------------------------------------------------------
 * Content types
 *
 * The post type is registered by the plugin, never the theme: switching theme
 * must not make a school's course catalogue disappear. `show_in_rest` is on so
 * courses are editable in the block editor and readable by the REST API.
 * ---------------------------------------------------------------------- */

/**
 * Register the course post type and its taxonomies.
 */
function academia_library_register() {
	register_post_type( 'academia_course', array(
		'labels'              => array(
			'name'                  => _x( 'Courses', 'Post type general name', 'academia-library' ),
			'singular_name'         => _x( 'Course', 'Post type singular name', 'academia-library' ),
			'menu_name'             => _x( 'Courses', 'Admin Menu text', 'academia-library' ),
			'add_new_item'          => __( 'Add course', 'academia-library' ),
			'edit_item'             => __( 'Edit course', 'academia-library' ),
			'new_item'              => __( 'New course', 'academia-library' ),
			'view_item'             => __( 'View course', 'academia-library' ),
			'search_items'          => __( 'Search courses', 'academia-library' ),
			'not_found'             => __( 'No courses found', 'academia-library' ),
			'not_found_in_trash'    => __( 'No courses in the bin', 'academia-library' ),
			'featured_image'        => __( 'Course image', 'academia-library' ),
			'set_featured_image'    => __( 'Set course image', 'academia-library' ),
			'remove_featured_image' => __( 'Remove course image', 'academia-library' ),
			'archives'              => __( 'Course archive', 'academia-library' ),
		),
		'public'              => true,
		'has_archive'         => true,
		'rewrite'             => array( 'slug' => 'courses', 'with_front' => false ),
		'menu_icon'           => 'dashicons-welcome-learn-more',
		'menu_position'       => 20,
		'supports'            => array( 'title', 'editor', 'excerpt', 'thumbnail', 'revisions', 'author', 'custom-fields' ),
		'show_in_rest'        => true,
		'rest_base'           => 'courses',
		'exclude_from_search' => false,
	) );

	register_taxonomy( 'academia_course_category', array( 'academia_course' ), array(
		'labels'            => array(
			'name'          => _x( 'Subjects', 'Taxonomy general name', 'academia-library' ),
			'singular_name' => _x( 'Subject', 'Taxonomy singular name', 'academia-library' ),
			'add_new_item'  => __( 'Add subject', 'academia-library' ),
			'edit_item'     => __( 'Edit subject', 'academia-library' ),
			'search_items'  => __( 'Search subjects', 'academia-library' ),
		),
		'public'            => true,
		'hierarchical'      => true,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'subject', 'with_front' => false ),
	) );

	register_taxonomy( 'academia_course_level', array( 'academia_course' ), array(
		'labels'            => array(
			'name'          => _x( 'Levels', 'Taxonomy general name', 'academia-library' ),
			'singular_name' => _x( 'Level', 'Taxonomy singular name', 'academia-library' ),
			'add_new_item'  => __( 'Add level', 'academia-library' ),
			'edit_item'     => __( 'Edit level', 'academia-library' ),
			'search_items'  => __( 'Search levels', 'academia-library' ),
		),
		'public'            => true,
		'hierarchical'      => false,
		'show_in_rest'      => true,
		'show_admin_column' => true,
		'rewrite'           => array( 'slug' => 'level', 'with_front' => false ),
	) );

	academia_library_register_meta();
}
add_action( 'init', 'academia_library_register' );

/**
 * The course fields.
 *
 * Every one is registered with `show_in_rest` and a sanitize callback, so the
 * block editor, the REST API and the Block Bindings API can all reach them and
 * nothing writes unvalidated data.
 *
 * @return array<string, array> Meta key => definition.
 */
function academia_library_fields() {
	return array(
		'_academia_duration'   => array(
			'type'     => 'string',
			'label'    => __( 'Duration', 'academia-library' ),
			'hint'     => __( 'For example “8 weeks” or “12 hours”.', 'academia-library' ),
			'sanitize' => 'sanitize_text_field',
		),
		'_academia_lessons'    => array(
			'type'     => 'integer',
			'label'    => __( 'Lessons', 'academia-library' ),
			'hint'     => __( 'How many lessons or sessions the course contains.', 'academia-library' ),
			'sanitize' => 'absint',
		),
		'_academia_level'      => array(
			'type'     => 'string',
			'label'    => __( 'Level', 'academia-library' ),
			'hint'     => __( 'Used only when no Level taxonomy term is set.', 'academia-library' ),
			'sanitize' => 'sanitize_text_field',
		),
		'_academia_price'      => array(
			'type'     => 'string',
			'label'    => __( 'Price', 'academia-library' ),
			'hint'     => __( 'Numbers only. Leave empty for a free course.', 'academia-library' ),
			'sanitize' => 'academia_library_sanitize_amount',
		),
		'_academia_sale_price' => array(
			'type'     => 'string',
			'label'    => __( 'Offer price', 'academia-library' ),
			'hint'     => __( 'Shown with the full price struck through.', 'academia-library' ),
			'sanitize' => 'academia_library_sanitize_amount',
		),
		'_academia_instructor' => array(
			'type'     => 'string',
			'label'    => __( 'Instructor', 'academia-library' ),
			'hint'     => __( 'The name shown on the course card.', 'academia-library' ),
			'sanitize' => 'sanitize_text_field',
		),
		'_academia_rating'     => array(
			'type'     => 'number',
			'label'    => __( 'Rating', 'academia-library' ),
			'hint'     => __( 'Between 0 and 5. Leave empty to hide the stars.', 'academia-library' ),
			'sanitize' => 'academia_library_sanitize_rating',
		),
		'_academia_reviews'    => array(
			'type'     => 'integer',
			'label'    => __( 'Reviews', 'academia-library' ),
			'hint'     => __( 'How many ratings the average is based on.', 'academia-library' ),
			'sanitize' => 'absint',
		),
	);
}

/**
 * Register every course field with the REST API and the editor.
 */
function academia_library_register_meta() {
	foreach ( academia_library_fields() as $key => $field ) {
		register_post_meta( 'academia_course', $key, array(
			'type'              => $field['type'],
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => $field['sanitize'],
			'auth_callback'     => static function ( $allowed, $meta_key, $post_id ) {
				return current_user_can( 'edit_post', $post_id );
			},
		) );
	}
}

/**
 * An amount: digits and at most one decimal point, or an empty string.
 *
 * Stored as a string rather than a float so an empty price stays
 * distinguishable from a zero one — "free" and "not priced yet" are different
 * states on a course card.
 *
 * @param mixed $value Raw value.
 * @return string
 */
function academia_library_sanitize_amount( $value ) {
	$value = trim( (string) $value );

	if ( '' === $value ) {
		return '';
	}

	$value = preg_replace( '/[^0-9.]/', '', $value );
	$parts = explode( '.', (string) $value );

	if ( count( $parts ) > 2 ) {
		$value = $parts[0] . '.' . $parts[1];
	}

	return is_numeric( $value ) ? $value : '';
}

/**
 * A rating clamped to 0-5.
 *
 * @param mixed $value Raw value.
 * @return float
 */
function academia_library_sanitize_rating( $value ) {
	return max( 0.0, min( 5.0, (float) $value ) );
}

/* -------------------------------------------------------------------------
 * Theme integration
 * ---------------------------------------------------------------------- */

/**
 * Whether the Academia theme (or a child of it) is active.
 *
 * The plugin adds to the theme rather than replacing anything, so the parts
 * that depend on the theme's rendering helpers stay quiet otherwise. The post
 * type itself is always registered — a user's courses must not vanish because
 * they previewed another theme.
 *
 * @return bool
 */
function academia_library_theme_active() {
	$theme = wp_get_theme();

	return 'academia' === $theme->get_stylesheet() || 'academia' === $theme->get_template();
}

/**
 * Flush rewrite rules once, on activation, so /courses/ resolves immediately.
 */
function academia_library_activate() {
	academia_library_register();
	flush_rewrite_rules();
}
register_activation_hook( __FILE__, 'academia_library_activate' );

/**
 * And again on deactivation, so the now-dead /courses/ rules go away.
 */
function academia_library_deactivate() {
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'academia_library_deactivate' );

require_once academia_library_path() . 'admin.php';
require_once academia_library_path() . 'filter.php';
require_once academia_library_path() . 'demo.php';
