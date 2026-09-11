<?php
/**
 * The Academia Library recommendation.
 *
 * Academia works without the plugin — inc/courses.php falls back to posts, and
 * to any of four LMS plugins — so this is a recommendation, never a
 * requirement. It is one dismissible notice on the theme's own screens, and it
 * never appears when a course source is already present.
 *
 * The plugin ships as its own zip rather than bundled inside the theme:
 * WordPress would otherwise reinstall it on every theme update, overwriting
 * whatever version the user has.
 *
 * @package Academia
 */

defined( 'ABSPATH' ) || exit;

/** Where the plugin lives once installed. */
const ACADEMIA_LIBRARY_FILE = 'academia-library/academia-library.php';

/** User meta key recording that the notice was dismissed. */
const ACADEMIA_LIBRARY_DISMISSED = 'academia_library_notice_dismissed';

/**
 * Whether the plugin is installed, whatever its activation state.
 *
 * @return bool
 */
function academia_library_installed() {
	if ( ! function_exists( 'get_plugins' ) ) {
		require_once ABSPATH . 'wp-admin/includes/plugin.php';
	}

	return array_key_exists( ACADEMIA_LIBRARY_FILE, get_plugins() );
}

/**
 * Whether the notice should be shown to the current user.
 *
 * @return bool
 */
function academia_library_notice_due() {
	if ( ! current_user_can( 'install_plugins' ) ) {
		return false;
	}

	if ( get_user_meta( get_current_user_id(), ACADEMIA_LIBRARY_DISMISSED, true ) ) {
		return false;
	}

	// A site already reading courses from somewhere does not need the nudge.
	if ( 'posts' !== academia_course_source()['slug'] ) {
		return false;
	}

	$screen = get_current_screen();

	if ( ! $screen ) {
		return false;
	}

	return in_array( $screen->id, array( 'dashboard', 'themes', 'appearance_page_academia-starter-sites' ), true );
}

/**
 * Render the notice.
 */
function academia_library_notice() {
	if ( ! academia_library_notice_due() ) {
		return;
	}

	$dismiss = wp_nonce_url(
		admin_url( 'admin-post.php?action=academia_dismiss_library_notice' ),
		'academia_dismiss_library_notice'
	);

	echo '<div class="notice notice-info is-dismissible academia-library-notice">';
	echo '<p><strong>' . esc_html__( 'Academia: add a course library', 'academia' ) . '</strong></p>';
	echo '<p>' . esc_html__( 'Academia can list courses with levels, durations, lesson counts and prices, and filter them without reloading the page. That needs the free Academia Library plugin. Without it the course sections fall back to your posts, which still works — just without the course details.', 'academia' ) . '</p>';

	echo '<p>';

	if ( academia_library_installed() ) {
		$activate = wp_nonce_url(
			admin_url( 'plugins.php?action=activate&plugin=' . urlencode( ACADEMIA_LIBRARY_FILE ) ),
			'activate-plugin_' . ACADEMIA_LIBRARY_FILE
		);

		echo '<a class="button button-primary" href="' . esc_url( $activate ) . '">' . esc_html__( 'Activate Academia Library', 'academia' ) . '</a> ';
	} else {
		echo '<a class="button button-primary" href="' . esc_url( 'https://colorlib.com/wp/themes/academia/#library' ) . '" target="_blank" rel="noopener noreferrer">' . esc_html__( 'Get Academia Library', 'academia' ) . '</a> ';
	}

	echo '<a class="button" href="' . esc_url( $dismiss ) . '">' . esc_html__( 'No thanks', 'academia' ) . '</a>';
	echo '</p></div>';
}
add_action( 'admin_notices', 'academia_library_notice' );

/**
 * Record the dismissal.
 */
function academia_dismiss_library_notice() {
	check_admin_referer( 'academia_dismiss_library_notice' );

	if ( ! current_user_can( 'install_plugins' ) ) {
		wp_die( esc_html__( 'You are not allowed to do that.', 'academia' ), '', array( 'response' => 403 ) );
	}

	update_user_meta( get_current_user_id(), ACADEMIA_LIBRARY_DISMISSED, 1 );

	wp_safe_redirect( wp_get_referer() ? wp_get_referer() : admin_url() );
	exit;
}
add_action( 'admin_post_academia_dismiss_library_notice', 'academia_dismiss_library_notice' );
