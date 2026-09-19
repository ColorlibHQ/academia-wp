<?php
/**
 * Visitor colour scheme.
 *
 * A site owner picks the palette; this lets a visitor choose whether to read it
 * light or dark. The neutrals swap to a dark set, and the palette's own primary,
 * primary-deep and accent are lightened just enough to stay legible on the dark
 * ground — so an Emerald site stays green in the dark rather than becoming a
 * different theme.
 *
 * Nothing is enabled until the site owner adds the toggle pattern, and no
 * script or stylesheet loads on pages without it.
 *
 * @package Academia
 */

defined( 'ABSPATH' ) || exit;

/**
 * Whether the current page renders a scheme toggle.
 *
 * @param bool|null $set Set the flag; omit to read it.
 * @return bool
 */
function academia_has_scheme_toggle( $set = null ) {
	static $has = false;

	if ( true === $set ) {
		$has = true;
	}

	return $has;
}

/**
 * Apply the stored scheme before the first paint.
 *
 * Printed in the head rather than enqueued, because a deferred script would let
 * the page paint in the wrong scheme and then flip.
 */
function academia_scheme_boot() {
	if ( ! academia_has_scheme_toggle() ) {
		return;
	}

	// phpcs:ignore WordPress.WP.EnqueuedResources.NonEnqueuedScript -- must run before paint.
	echo '<script>(function(){try{var s=localStorage.getItem("academia-scheme");if(s==="dark"||s==="light"){document.documentElement.setAttribute("data-academia-scheme",s);}}catch(e){}})();</script>' . "\n";
}
add_action( 'wp_head', 'academia_scheme_boot', 1 );

/**
 * Load the toggle script and the dark tokens only where the toggle is used.
 */
function academia_scheme_assets() {
	if ( ! academia_has_scheme_toggle() ) {
		return;
	}

	wp_enqueue_style(
		'academia-wp-academia-scheme',
		get_theme_file_uri( 'assets/css/scheme.css' ),
		array(),
		ACADEMIA_VERSION
	);

	wp_enqueue_script(
		'academia-wp-academia-scheme-toggle',
		get_theme_file_uri( 'assets/js/scheme-toggle.js' ),
		array(),
		ACADEMIA_VERSION,
		true
	);

	// The label names the action, so it has to change with the state. Both
	// strings are passed here rather than written into the pattern: a data
	// attribute on a core Button's link is markup save() does not emit, which
	// fails block validation.
	wp_localize_script( 'academia-scheme-toggle', 'academiaScheme', array(
		'dark'      => __( 'Dark', 'academia' ),
		'light'     => __( 'Light', 'academia' ),
		/* translators: %s: the appearance being switched to, "dark" or "light". */
		'switchTo'  => __( 'Switch to %s appearance', 'academia' ),
	) );
}
add_action( 'wp_enqueue_scripts', 'academia_scheme_assets', 20 );

/**
 * Mark the page as carrying a toggle when it renders.
 *
 * Watched on `render_block` rather than a specific block type: the toggle is a
 * real <button> in a core/html block, because core/button cannot hold an SVG
 * without failing block validation. A cheap string test on the rendered output
 * keeps this independent of which block the toggle is wrapped in.
 *
 * @param string $content Rendered block content.
 * @return string
 */
function academia_scheme_detect( $content ) {
	if ( ! academia_has_scheme_toggle() && false !== strpos( $content, 'academia-scheme-toggle' ) ) {
		academia_has_scheme_toggle( true );
	}

	return $content;
}
add_filter( 'render_block', 'academia_scheme_detect' );
