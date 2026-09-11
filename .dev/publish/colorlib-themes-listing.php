<?php
/**
 * Add Academia to the /wp/themes/ listing page (5091).
 *
 * Three edits, each matching the markup already on the page:
 *   1. a "What are you building?" pick for a school or course site
 *   2. a grid entry in "Free WordPress themes", straight after Unapp
 *   3. the section lede, which names which themes come from us rather than
 *      the WordPress.org directory
 *
 * Idempotent: it bails if Academia is already listed.
 */

defined( 'ABSPATH' ) || exit;

$page_id = 5091;
$shot    = wp_get_attachment_url( 381449 );
$content = get_post_field( 'post_content', $page_id );

if ( false !== strpos( $content, 'theme-academia' ) ) {
	echo "already listed — nothing to do\n";
	return;
}

if ( ! $shot ) {
	echo "ERROR: screenshot attachment 381449 not found\n";
	return;
}

$before = strlen( $content );

/* ---------------------------------------------------------------- 1. pick */
// Insert before the SaaS pick so education sits with the other institution
// choices rather than at the end.
$saas_pick = '<li class="clt-pick"><span class="clt-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><rect x="3" y="4" width="18" height="13" rx="2"/><line x1="8" y1="21" x2="16" y2="21"/><line x1="12" y1="17" x2="12" y2="21"/></svg></span><span><span class="clt-pick__lab">A SaaS or app site</span>';

$academia_pick = '<li class="clt-pick"><span class="clt-ico"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false"><path d="M22 10L12 5 2 10l10 5 10-5z"/><path d="M6 12v5c0 1.7 2.7 3 6 3s6-1.3 6-3v-5"/></svg></span><span><span class="clt-pick__lab">A school or course site</span><span class="clt-pick__themes"><a href="#theme-academia">Academia</a></span></span></li>';

if ( false === strpos( $content, $saas_pick ) ) {
	echo "ERROR: could not find the SaaS pick to insert before\n";
	return;
}

$content = str_replace( $saas_pick, $academia_pick . $saas_pick, $content );

/* ---------------------------------------------------------- 2. grid entry */
$unapp_entry_end = '<span class="clt-theme__foot"><span class="clt-theme__installs"></span><span class="clt-theme__cta">View theme &rarr;</span></span></span></li>';
$unapp_start     = strpos( $content, '<li class="clt-theme" id="theme-unapp">' );

if ( false === $unapp_start ) {
	echo "ERROR: could not find the Unapp grid entry\n";
	return;
}

$unapp_end = strpos( $content, $unapp_entry_end, $unapp_start );

if ( false === $unapp_end ) {
	echo "ERROR: could not find the end of the Unapp grid entry\n";
	return;
}

$insert_at = $unapp_end + strlen( $unapp_entry_end );

$academia_entry = '<li class="clt-theme" id="theme-academia">'
	. '<span class="clt-theme__shot"><img src="' . esc_url( $shot ) . '" alt="Academia free WordPress block theme homepage showing its online academy starter" width="1200" height="815" loading="lazy" decoding="async" /></span>'
	. '<span class="clt-theme__body">'
	. '<span class="clt-theme__kind">Block theme for the Site Editor</span>'
	. '<h3 class="clt-theme__name"><a href="https://colorlib.com/wp/themes/academia/">Academia</a></h3>'
	. '<span class="clt-theme__desc">For schools, universities and course providers. A course catalogue visitors can filter, search and sort without a page reload, and six starter sites to begin from.</span>'
	. '<span class="clt-theme__foot"><span class="clt-theme__installs"></span><span class="clt-theme__cta">View theme &rarr;</span></span>'
	. '</span></li>';

$content = substr( $content, 0, $insert_at ) . $academia_entry . substr( $content, $insert_at );

/* ----------------------------------------------------------- 3. the lede */
$old_lede = '12 of them install straight from the WordPress.org directory; Unapp downloads from us.';
$new_lede = '12 of them install straight from the WordPress.org directory; Unapp and Academia download from us.';

if ( false !== strpos( $content, $old_lede ) ) {
	$content = str_replace( $old_lede, $new_lede, $content );
	echo "lede updated\n";
} else {
	echo "NOTE: the lede sentence did not match — check it by hand\n";
}

/* --------------------------------------------------------------- save it */
// WPBakery markup must not go through kses, which strips shortcode attributes.
$kses = has_filter( 'content_save_pre', 'wp_filter_post_kses' );

if ( $kses ) {
	kses_remove_filters();
}

$result = wp_update_post( array( 'ID' => $page_id, 'post_content' => $content ), true );

if ( $kses ) {
	kses_init_filters();
}

if ( is_wp_error( $result ) ) {
	echo 'ERROR: ' . $result->get_error_message() . "\n";
	return;
}

$after = strlen( get_post_field( 'post_content', $page_id ) );

echo "content: {$before} -> {$after} bytes\n";
echo 'academia pick: ' . ( false !== strpos( get_post_field( 'post_content', $page_id ), '#theme-academia' ) ? 'yes' : 'NO' ) . "\n";
echo 'academia grid entry: ' . ( false !== strpos( get_post_field( 'post_content', $page_id ), 'id="theme-academia"' ) ? 'yes' : 'NO' ) . "\n";
