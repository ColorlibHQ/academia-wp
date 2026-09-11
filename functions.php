<?php
/**
 * Academia theme setup.
 *
 * Academia is a block theme: the layout lives in templates/*.html, the design
 * system in theme.json, and the sections in patterns/*.php. This file carries
 * only what those cannot express — supports flags, asset enqueues, block
 * styles, pattern categories and the graceful-degradation guards.
 *
 * @package Academia
 */

defined( 'ABSPATH' ) || exit;

define( 'ACADEMIA_VERSION', '1.0.4' );

/**
 * Theme supports.
 *
 * A block theme gets most of this from theme.json; what remains is the set of
 * flags that have no theme.json equivalent.
 */
function academia_setup() {
	load_theme_textdomain( 'academia', get_theme_file_path( 'languages' ) );

	add_theme_support( 'title-tag' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' ) );
	add_theme_support( 'editor-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'custom-logo', array(
		'height'      => 64,
		'width'       => 240,
		'flex-height' => true,
		'flex-width'  => true,
	) );

	// style.css is loaded in the editor canvas too, so classic content and the
	// course cards look the same there as on the front end.
	add_editor_style( 'style.css' );
}
add_action( 'after_setup_theme', 'academia_setup' );

/**
 * Front-end styles.
 */
function academia_enqueue_styles() {
	wp_enqueue_style( 'academia-style', get_stylesheet_uri(), array(), ACADEMIA_VERSION );
}
add_action( 'wp_enqueue_scripts', 'academia_enqueue_styles' );

/**
 * WooCommerce styling, loaded only where it is needed.
 *
 * Woo sizes its own product grid with auto-fill against its 1.25em gap, so
 * widening the gap to the theme's spacing scale silently drops three columns
 * to two. academia-woocommerce.css sets the tracks explicitly.
 */
function academia_woocommerce_styles() {
	if ( ! class_exists( 'WooCommerce' ) ) {
		return;
	}

	wp_enqueue_style(
		'academia-woocommerce',
		get_theme_file_uri( 'assets/css/woocommerce.css' ),
		array( 'academia-style' ),
		ACADEMIA_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'academia_woocommerce_styles', 20 );

/**
 * Block styles.
 *
 * Registered here rather than in theme.json because each one needs a CSS file
 * that only loads when a block using it renders.
 */
function academia_block_styles() {
	$styles = array(
		'core/button'  => array(
			'academia-ghost' => __( 'Ghost', 'academia' ),
			'squared'        => __( 'Squared', 'academia' ),
		),
		'core/list'    => array(
			'academia-checklist' => __( 'Checklist', 'academia' ),
			'academia-dash'      => __( 'Dashed', 'academia' ),
			'academia-steps'     => __( 'Numbered steps', 'academia' ),
			'academia-two-col'   => __( 'Two columns', 'academia' ),
		),
		'core/image'   => array(
			'academia-frame'  => __( 'Framed', 'academia' ),
			'academia-browser' => __( 'Browser', 'academia' ),
			'academia-device' => __( 'Device', 'academia' ),
		),
		'core/quote'   => array(
			'academia-testimonial' => __( 'Testimonial', 'academia' ),
		),
		'core/details' => array(
			'academia-faq' => __( 'FAQ card', 'academia' ),
		),
		'core/group'   => array(
			'academia-rail' => __( 'Scroll rail', 'academia' ),
		),
	);

	// No `style_handle` on any of these: their CSS is in style.css, which always
	// loads. A handle would only be enqueued while WordPress serves separate
	// core block assets, and any plugin can turn that off site-wide — leaving
	// the class rendered and unstyled.
	foreach ( $styles as $block => $variations ) {
		foreach ( $variations as $name => $label ) {
			register_block_style( $block, array(
				'name'  => $name,
				'label' => $label,
			) );
		}
	}
}
add_action( 'init', 'academia_block_styles' );

/**
 * Pattern categories.
 *
 * Course-specific categories sit alongside the generic ones so the inserter
 * separates "a section about courses" from "a section about the school".
 */
function academia_pattern_categories() {
	$categories = array(
		'academia'          => array(
			'label'       => _x( 'Academia', 'Block pattern category', 'academia' ),
			'description' => __( 'Every Academia section.', 'academia' ),
		),
		'academia_hero'     => array(
			'label'       => _x( 'Academia: headers', 'Block pattern category', 'academia' ),
			'description' => __( 'Page openings and hero sections.', 'academia' ),
		),
		'academia_courses'  => array(
			'label'       => _x( 'Academia: courses', 'Block pattern category', 'academia' ),
			'description' => __( 'Course grids, categories, curriculum and enrolment.', 'academia' ),
		),
		'academia_people'   => array(
			'label'       => _x( 'Academia: people', 'Block pattern category', 'academia' ),
			'description' => __( 'Instructors, staff and student stories.', 'academia' ),
		),
		'academia_proof'    => array(
			'label'       => _x( 'Academia: proof', 'Block pattern category', 'academia' ),
			'description' => __( 'Results, accreditation, testimonials and statistics.', 'academia' ),
		),
		'academia_pricing'  => array(
			'label'       => _x( 'Academia: pricing', 'Block pattern category', 'academia' ),
			'description' => __( 'Tuition, plans and enrolment terms.', 'academia' ),
		),
		'academia_campus'   => array(
			'label'       => _x( 'Academia: campus', 'Block pattern category', 'academia' ),
			'description' => __( 'About the institution, facilities, events and contact.', 'academia' ),
		),
		'academia_cta'      => array(
			'label'       => _x( 'Academia: calls to action', 'Block pattern category', 'academia' ),
			'description' => __( 'Enrolment prompts, prospectus requests and newsletters.', 'academia' ),
		),
		'academia_content'  => array(
			'label'       => _x( 'Academia: content', 'Block pattern category', 'academia' ),
			'description' => __( 'Text, media and FAQ sections.', 'academia' ),
		),
		'academia_utility'  => array(
			'label'       => _x( 'Academia: utility', 'Block pattern category', 'academia' ),
			'description' => __( 'Headers, footers and small parts.', 'academia' ),
		),
		'academia_page'     => array(
			'label'       => _x( 'Academia: pages', 'Block pattern category', 'academia' ),
			'description' => __( 'Whole-page starters.', 'academia' ),
		),
	);

	foreach ( $categories as $name => $args ) {
		register_block_pattern_category( $name, $args );
	}
}
add_action( 'init', 'academia_pattern_categories' );

/**
 * Blocks that only exist in newer WordPress versions.
 *
 * Academia uses core/accordion, core/breadcrumbs, core/query-total and
 * core/post-time-to-read, all of which landed in 7.0. On 6.6 a pattern built
 * from a missing block would render an error comment, so patterns that need
 * one are unregistered and stray instances render nothing.
 */
function academia_newer_blocks() {
	return array( 'core/accordion', 'core/accordion-item', 'core/accordion-heading', 'core/accordion-panel', 'core/breadcrumbs', 'core/query-total', 'core/post-time-to-read' );
}

/**
 * Hide patterns whose blocks this WordPress does not have.
 */
function academia_unregister_unsupported_patterns() {
	$registry = WP_Block_Type_Registry::get_instance();
	$missing   = array();

	foreach ( academia_newer_blocks() as $block ) {
		if ( ! $registry->is_registered( $block ) ) {
			$missing[] = $block;
		}
	}

	if ( empty( $missing ) ) {
		return;
	}

	// Patterns that cannot degrade: they are built around the missing block.
	$dependent = array( 'academia/course-curriculum', 'academia/faq-accordion' );
	$patterns  = WP_Block_Patterns_Registry::get_instance();

	foreach ( $dependent as $slug ) {
		if ( $patterns->is_registered( $slug ) ) {
			unregister_block_pattern( $slug );
		}
	}
}
add_action( 'init', 'academia_unregister_unsupported_patterns', 20 );

/**
 * Render nothing for a block this WordPress does not support.
 *
 * @param string $block_content Rendered block.
 * @param array  $block         Parsed block.
 * @return string
 */
function academia_skip_unsupported_blocks( $block_content, $block ) {
	if ( empty( $block['blockName'] ) ) {
		return $block_content;
	}

	if ( ! in_array( $block['blockName'], academia_newer_blocks(), true ) ) {
		return $block_content;
	}

	return WP_Block_Type_Registry::get_instance()->is_registered( $block['blockName'] ) ? $block_content : '';
}
add_filter( 'render_block', 'academia_skip_unsupported_blocks', 10, 2 );

/**
 * Make shortcode blocks work inside block templates.
 *
 * core/shortcode's render callback only runs wpautop(); the shortcodes
 * themselves are expanded by do_shortcode() on `the_content`. That filter runs
 * for post content and not for a block template, so a shortcode placed in a
 * template — or in a pattern a template references — renders as its own literal
 * text. Academia's course sections are shortcodes precisely so they survive
 * being expanded into post content, and they appear in both places, so the
 * expansion has to happen in both.
 *
 * do_shortcode() on already-expanded output is a no-op, so this is safe to
 * apply unconditionally rather than trying to detect which context we are in.
 *
 * @param string $block_content Rendered block.
 * @return string
 */
function academia_render_shortcode_block( $block_content ) {
	return do_shortcode( $block_content );
}
add_filter( 'render_block_core/shortcode', 'academia_render_shortcode_block' );

/**
 * Load the stats counter only when a counting paragraph actually renders.
 *
 * @param string $block_content Rendered block.
 * @param array  $block         Parsed block.
 * @return string
 */
function academia_maybe_enqueue_counter( $block_content, $block ) {
	if ( false === strpos( $block_content, 'academia-count' ) ) {
		return $block_content;
	}

	if ( ! wp_script_is( 'academia-counter', 'enqueued' ) ) {
		wp_enqueue_script(
			'academia-counter',
			get_theme_file_uri( 'assets/js/counter.js' ),
			array(),
			ACADEMIA_VERSION,
			array(
				'in_footer' => true,
				'strategy'  => 'defer',
			)
		);
	}

	return $block_content;
}
add_filter( 'render_block_core/paragraph', 'academia_maybe_enqueue_counter', 10, 2 );

/**
 * Feature modules.
 */
require get_theme_file_path( 'inc/courses.php' );
require get_theme_file_path( 'inc/front-page-setup.php' );
require get_theme_file_path( 'inc/starter-sites.php' );
require get_theme_file_path( 'inc/forms.php' );
require get_theme_file_path( 'inc/scheme.php' );
require get_theme_file_path( 'inc/plugin-notice.php' );
require get_theme_file_path( 'inc/updates.php' );
