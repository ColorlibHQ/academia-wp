<?php
/**
 * Rebuild the Academia product page (381441) with the starter gallery.
 *
 * The first cut had no screenshots — icon boxes stood in for the starters,
 * because at that point only one demo existed. There are now six demo subsites
 * and six screenshots, so the starters can be shown rather than described,
 * which is the thing a person actually wants from this page.
 *
 * Stays a DRAFT. colorlib.com's convention is draft first, publish separately.
 */

defined( 'ABSPATH' ) || exit;

$page_id  = 381441;
$hero_img    = 381440;
$browser_img = 381453;
$download = 'https://updates.colorlib.com/download/theme/academia.zip';
$demo     = 'https://colorlibhub.com/academia/';
$docs     = 'https://docs.colorlib.com/academia/';

// vc_btn's `link` attribute is WPBakery's own "url:…|title:…|target:…"
// encoding. It splits on "|" and then on the first ":", so a raw URL is cut
// off at "https:" and the button renders href="http://https". Every URL that
// goes into a `link` attribute must be percent-encoded first.
$download_enc = rawurlencode( $download );
$demo_enc     = rawurlencode( $demo );
$docs_enc     = rawurlencode( $docs );

// image id => [heading, summary, demo slug, swatch]
$starters = array(
	381443 => array( 'Online academy', 'A course catalogue with levels and prices, the tutors who teach it, and enrolment.', '', '#0f766e' ),
	381448 => array( 'University &amp; college', 'Faculties and programmes, admissions with its deadlines, research and campus life.', '-university', '#4338ca' ),
	381446 => array( 'School &amp; kindergarten', 'Classes by age group, the teaching team, the term calendar and how to arrange a visit.', '-school', '#c2410c' ),
	381444 => array( 'Coding bootcamp', 'The syllabus week by week, cohort dates, hiring outcomes and financing.', '-bootcamp', '#334155' ),
	381445 => array( 'Language school', 'Courses by level from A1 to C2, in classes of nine, taught by native speakers.', '-language', '#15803d' ),
	381447 => array( 'Arts &amp; music studio', 'Workshops and one-to-one tuition, the studio itself, student work and a booking form.', '-studio', '#9333ea' ),
);

$teasers = '';
$i       = 0;

foreach ( $starters as $img => $s ) {
	list( $heading, $summary, $slug, $swatch ) = $s;

	if ( 0 === $i % 3 ) {
		$teasers .= ( $i ? '[/vc_row]' : '' ) . '[vc_row equal_height="yes" content_placement="top" css=".vc_custom_academia_g' . $i . '{padding-top:0px !important;padding-bottom:10px !important;background-color:#f7f7f5 !important;}"]';
	}

	$teasers .= '[vc_column width="1/3"][vcex_teaser image="' . $img . '"'
		. ' heading="' . $heading . '" heading_size="20px" content_font_size="14px"'
		. ' url="https://colorlibhub.com/academia' . $slug . '/" url_target="blank"'
		. ' show_button="true" button_text="See the demo"'
		. ' button_background="' . $swatch . '" button_color="#ffffff"'
		. ' button_border_radius="999px" button_font_size="13px" button_padding="9px 20px"'
		. ' img_aspect_ratio="3/2" img_object_fit="cover" img_border_radius="10px"'
		. ' style="two" border_radius="12px" bottom_margin="30px"]'
		. $summary . '[/vcex_teaser][/vc_column]';

	++$i;
}

$teasers .= '[/vc_row]';

$content = <<<HTML
[vc_row css=".vc_custom_academia006{padding-top:64px !important;padding-bottom:44px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_heading text="A course catalogue people can actually search." tag="h2" font_size="46px" text_align="center" bottom_margin="20px" font_weight="700"][vc_column_text css=".vc_custom_academia001{text-align:center !important;font-size:18px !important;}"]Academia is a free WordPress block theme for schools, universities, academies and online course providers. Courses filter, search and sort without reloading the page — and they still filter correctly with JavaScript switched off. Pick one of six starter sites and you have a finished site you can take apart in the Site Editor without touching code.[/vc_column_text][vc_column_text css=".vc_custom_academia002{text-align:center !important;margin-top:26px !important;}"][vc_btn title="Download Academia" style="flat" color="green" link="url:{$download_enc}|title:Download%20Academia|target:_blank" css=".vc_custom_academia003{display:inline-block !important;vertical-align:middle !important;margin-right:12px !important;margin-bottom:10px !important;}" i_icon_fontawesome="fa-solid fa-download" add_icon="true"][vc_btn title="Live demo" style="flat" color="grey" link="url:{$demo_enc}|title:Live%20demo|target:_blank" css=".vc_custom_academia004{display:inline-block !important;vertical-align:middle !important;margin-right:12px !important;margin-bottom:10px !important;}" i_icon_fontawesome="fa-regular fa-eye" add_icon="true"][vc_btn title="Documentation" style="flat" color="grey" link="url:{$docs_enc}|title:Documentation|target:_blank" css=".vc_custom_academia005{display:inline-block !important;vertical-align:middle !important;margin-right:12px !important;margin-bottom:10px !important;}" i_icon_fontawesome="fa-solid fa-book" add_icon="true"][/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_academia007{padding-top:0px !important;padding-bottom:64px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_image image_id="{$hero_img}" align="center" border_radius="14px" bottom_margin="0px"][/vc_column][/vc_row]

[vc_row css=".vc_custom_academia008{padding-top:56px !important;padding-bottom:44px !important;}"][vc_column width="1/4"][vcex_milestone number="6" caption="Starter sites" animated="true" text_align="center" number_size="46px" number_weight="700" caption_size="13px"][/vc_column][vc_column width="1/4"][vcex_milestone number="58" caption="Block patterns" animated="true" text_align="center" number_size="46px" number_weight="700" caption_size="13px"][/vc_column][vc_column width="1/4"][vcex_milestone number="40" caption="Palette &amp; type combinations" animated="true" text_align="center" number_size="46px" number_weight="700" caption_size="13px"][/vc_column][vc_column width="1/4"][vcex_milestone number="18" caption="Templates" animated="true" text_align="center" number_size="46px" number_weight="700" caption_size="13px"][/vc_column][/vc_row]

[vc_row css=".vc_custom_academia009{padding-bottom:24px !important;}"][vc_column width="1/1"][vcex_heading text="The course browser is the whole point" tag="h2" font_size="34px" text_align="center" bottom_margin="14px" font_weight="700"][vc_column_text css=".vc_custom_academia0091{text-align:center !important;max-width:760px !important;margin-left:auto !important;margin-right:auto !important;}"]Search by name, narrow by subject and level, sort by newest, price or rating — with no page reload. And it still works with JavaScript switched off, because the server renders the finished result and the JavaScript only removes the navigation. Most course themes get that the other way round, and break for anyone whose scripts are blocked.[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_academia0092{padding-bottom:56px !important;}"][vc_column width="1/1"][vcex_image image_id="{$browser_img}" align="center" border_radius="12px" bottom_margin="0px" img_shadow="two"][/vc_column][/vc_row]

[vc_row css=".vc_custom_academia010{padding-top:44px !important;padding-bottom:20px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_heading text="Courses, however you keep them" tag="h2" font_size="34px" text_align="center" bottom_margin="14px" font_weight="700"][vc_column_text css=".vc_custom_academia011{text-align:center !important;}"]Academia reads courses from whatever your site already has, and renders all of them with the same card design.[/vc_column_text][/vc_column][/vc_row][vc_row css=".vc_custom_academia012{padding-bottom:44px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/3"][vcex_icon_box style="one" heading="Academia Library" icon="fa-solid fa-graduation-cap" icon_color="#0f766e" heading_size="19px"]Our free companion plugin adds a Course content type with levels, durations, lesson counts, prices, instructors and ratings — and upgrades the browser so filtering and sorting happen without a page load.[/vcex_icon_box][/vc_column][vc_column width="1/3"][vcex_icon_box style="one" heading="Your existing LMS" icon="fa-solid fa-plug" icon_color="#0f766e" heading_size="19px"]Already running Tutor LMS, LifterLMS, Sensei or LearnDash? Academia reads their courses and maps their fields onto the same cards. Nothing to migrate.[/vcex_icon_box][/vc_column][vc_column width="1/3"][vcex_icon_box style="one" heading="Just your posts" icon="fa-regular fa-file-lines" icon_color="#0f766e" heading_size="19px"]With no plugin at all, courses fall back to posts in a category called “courses”. Fewer details on the card, and the theme still works on a bare install.[/vcex_icon_box][/vc_column][/vc_row]

[vc_row css=".vc_custom_academia020{padding-top:44px !important;padding-bottom:10px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_heading text="Six starter sites" tag="h2" font_size="34px" text_align="center" bottom_margin="14px" font_weight="700"][vc_column_text css=".vc_custom_academia021{text-align:center !important;max-width:760px !important;margin-left:auto !important;margin-right:auto !important;}"]Each one brings its own palette, typeface, home page, supporting pages, menu and call to action — and its own words, so a university does not read as an online academy. Every one is a live site you can click through before you download anything.[/vc_column_text][/vc_column][/vc_row]{$teasers}

[vc_row css=".vc_custom_academia030{padding-top:44px !important;padding-bottom:16px !important;}"][vc_column width="1/1"][vcex_heading text="Set up in three steps" tag="h2" font_size="34px" text_align="center" bottom_margin="24px" font_weight="700"][vcex_steps style="numbered" columns="3" steps="%5B%7B%22title%22%3A%22Activate%20the%20theme%22%2C%22text%22%3A%22Academia%20creates%20a%20home%20page%20and%20a%20blog%20page%20and%20points%20Settings%20%E2%86%92%20Reading%20at%20them.%20Already%20have%20a%20static%20front%20page%3F%20Nothing%20is%20touched.%22%7D%2C%7B%22title%22%3A%22Add%20your%20courses%22%2C%22text%22%3A%22Install%20Academia%20Library%20and%20create%20nine%20example%20courses%20in%20one%20click%2C%20or%20point%20the%20theme%20at%20the%20LMS%20you%20already%20run.%22%7D%2C%7B%22title%22%3A%22Pick%20a%20starter%22%2C%22text%22%3A%22Appearance%20%E2%86%92%20Starter%20Sites.%20Choose%20a%20look%2C%20and%20edit%20every%20word%20of%20it%20in%20the%20Site%20Editor.%22%7D%5D"][/vc_column][/vc_row]

[vc_row css=".vc_custom_academia040{padding-top:44px !important;padding-bottom:20px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_heading text="What else is in it" tag="h2" font_size="34px" text_align="center" bottom_margin="24px" font_weight="700"][/vc_column][/vc_row][vc_row css=".vc_custom_academia041{padding-bottom:20px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/3"][vcex_icon_box style="one" heading="Light and dark" icon="fa-solid fa-adjust" icon_color="#0f766e" heading_size="18px"]A visitor-facing toggle that lifts the active palette rather than replacing it, so a green site stays green in the dark. Every text colour meets WCAG AA in both schemes — measured, not asserted.[/vcex_icon_box][/vc_column][vc_column width="1/3"][vcex_icon_box style="one" heading="Eight palettes, five typefaces" icon="fa-solid fa-paint-brush" icon_color="#0f766e" heading_size="18px"]Colour and typography change independently, so any of the 40 combinations is one click in Appearance → Editor → Styles.[/vcex_icon_box][/vc_column][vc_column width="1/3"][vcex_icon_box style="one" heading="No external requests" icon="fa-solid fa-bolt" icon_color="#0f766e" heading_size="18px"]Six self-hosted variable fonts, no Google Fonts, no jQuery, and no JavaScript library of any kind. Images ship as AVIF.[/vcex_icon_box][/vc_column][/vc_row][vc_row css=".vc_custom_academia042{padding-bottom:44px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/3"][vcex_icon_box style="one" heading="Your courses stay yours" icon="fa-solid fa-unlock" icon_color="#0f766e" heading_size="18px"]The Course content type belongs to the plugin, not the theme, so changing theme leaves your catalogue intact and editable. No hostages.[/vcex_icon_box][/vc_column][vc_column width="1/3"][vcex_icon_box style="one" heading="Your forms, styled" icon="fa-regular fa-envelope" icon_color="#0f766e" heading_size="18px"]Contact sections render whichever of ten form plugins you already use. A theme must not process submissions, so Academia never does.[/vcex_icon_box][/vc_column][vc_column width="1/3"][vcex_icon_box style="one" heading="WooCommerce ready" icon="fa-solid fa-shopping-cart" icon_color="#0f766e" heading_size="18px"]Shop, product, cart, checkout and confirmation templates, with the product grid's columns set explicitly so they do not collapse.[/vcex_icon_box][/vc_column][/vc_row]

[vc_row css=".vc_custom_academia050{padding-top:44px !important;padding-bottom:44px !important;}"][vc_column width="1/1"][vcex_heading text="Questions" tag="h2" font_size="34px" text_align="center" bottom_margin="24px" font_weight="700"][vcex_toggle heading="Do I need the Academia Library plugin?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]No. Without it, course sections use your posts and the filter still works with a page load per change. The plugin adds the course fields — level, duration, lessons, price, rating — and filtering without a reload.[/vcex_toggle][vcex_toggle heading="Will I lose my courses if I change theme?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]No. Courses are registered by the plugin, not the theme, so they stay in your database and stay editable whatever theme is active.[/vcex_toggle][vcex_toggle heading="Can I use the LMS I already have?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]Yes. Tutor LMS, LifterLMS, Sensei and LearnDash are read automatically, and any other source can be added with one filter.[/vcex_toggle][vcex_toggle heading="Does the course filter need JavaScript?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]No. The server renders the finished, correct result for whatever is in the address bar; the JavaScript only removes the page load. With scripts blocked the form still filters, sorts and paginates.[/vcex_toggle][vcex_toggle heading="Will applying a starter delete my content?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]No. A starter creates pages and never deletes any. Applying a second one leaves the first home page in your Pages list, and Settings → Reading can be switched back at any time. Courses, posts and media are never touched.[/vcex_toggle][vcex_toggle heading="Can I use it on a client site?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]Yes. GPL v2 or later, no attribution required, no licence key and no seat limit.[/vcex_toggle][vcex_toggle heading="What does Academia cost?" heading_font_size="17px" style="boxed" padding_y="16px" padding_x="20px" bottom_margin="12px"]Nothing. It is free, and licensed GPL v2 or later — the same licence as WordPress itself.[/vcex_toggle][/vc_column][/vc_row]

[vc_row css=".vc_custom_academia060{padding-top:56px !important;padding-bottom:56px !important;background-color:#f7f7f5 !important;}"][vc_column width="1/1"][vcex_heading text="Download Academia" tag="h2" font_size="34px" text_align="center" bottom_margin="14px" font_weight="700"][vc_column_text css=".vc_custom_academia061{text-align:center !important;}"]Free, GPL v2 or later. Requires WordPress 6.6 or newer and PHP 7.4 or newer.[/vc_column_text][vc_column_text css=".vc_custom_academia062{text-align:center !important;margin-top:20px !important;}"][vc_btn title="Download Academia" style="flat" color="green" link="url:{$download_enc}|title:Download%20Academia|target:_blank" css=".vc_custom_academia063{display:inline-block !important;vertical-align:middle !important;margin-right:12px !important;margin-bottom:10px !important;}" i_icon_fontawesome="fa-solid fa-download" add_icon="true"][vc_btn title="Read the docs" style="flat" color="grey" link="url:{$docs_enc}|title:Read%20the%20docs|target:_blank" css=".vc_custom_academia064{display:inline-block !important;vertical-align:middle !important;margin-bottom:10px !important;}" i_icon_fontawesome="fa-solid fa-book" add_icon="true"][/vc_column_text][/vc_column][/vc_row]
HTML;

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

// WPBakery keeps every `css="..."` rule in the `_wpb_shortcodes_custom_css`
// post meta and only regenerates it when the page is saved through the builder
// UI. Updating post_content programmatically leaves that meta at whatever the
// first save produced — so every css= edit after the first publish is silently
// inert. This is why the buttons kept stacking and the grey bands kept working:
// the bands were in version one, the button rule was not.
if ( function_exists( 'visual_composer' ) ) {
	$vc = visual_composer();

	if ( method_exists( $vc, 'buildShortcodesCss' ) ) {
		$vc->buildShortcodesCss( $page_id, 'custom' );
		$vc->buildShortcodesCss( $page_id, 'default' );
		echo "custom css rebuilt\n";
	} elseif ( method_exists( $vc, 'buildShortcodesCustomCss' ) ) {
		$vc->buildShortcodesCustomCss( $page_id );
		echo "custom css rebuilt (legacy)\n";
	} else {
		echo "WARNING: could not rebuild the custom css — css= rules will be stale\n";
	}
} else {
	echo "WARNING: visual_composer() unavailable — css= rules will be stale\n";
}

$css = (string) get_post_meta( $page_id, '_wpb_shortcodes_custom_css', true );
echo 'css meta: ' . strlen( $css ) . " bytes, inline-block present: " . ( false !== strpos( $css, 'inline-block' ) ? 'yes' : 'NO' ) . "\n";

$saved = get_post_field( 'post_content', $page_id );

echo "page: $page_id (" . get_post_status( $page_id ) . ")\n";
echo 'length: ' . strlen( $saved ) . "\n";
echo 'starter teasers: ' . substr_count( $saved, '[vcex_teaser' ) . "\n";
$count_url = function ( $needle ) use ( $saved ) {
	// A URL appears plain in some attributes and percent-encoded inside
	// vc_btn's `link`, so counting one form under-reports.
	return substr_count( $saved, $needle ) + substr_count( $saved, rawurlencode( $needle ) );
};

echo 'demo links: ' . $count_url( 'https://colorlibhub.com/academia' ) . "\n";
echo 'docs links: ' . $count_url( 'https://docs.colorlib.com/academia/' ) . "\n";
echo 'counted downloads: ' . $count_url( 'https://updates.colorlib.com/download/theme/academia.zip' ) . "\n";
echo 'unbalanced rows: ' . ( substr_count( $saved, '[vc_row' ) - substr_count( $saved, '[/vc_row]' ) ) . "\n";
// A button whose href is dead is worse than no button, so check the rendered
// anchors rather than the shortcode text.
$rendered = do_shortcode( $saved );
preg_match_all( '#<a[^>]+href="([^"]*)"#', $rendered, $hrefs );
$dead = array_values( array_filter( array_unique( $hrefs[1] ), function ( $h ) {
	return '' === $h || '#' === $h || false !== strpos( $h, 'http://https' ) || 0 === strpos( $h, 'url:' );
} ) );
echo 'rendered links: ' . count( array_unique( $hrefs[1] ) ) . ', dead: ' . count( $dead ) . "\n";

foreach ( $dead as $d ) {
	echo '  DEAD: ' . $d . "\n";
}

echo 'unbalanced columns: ' . ( substr_count( $saved, '[vc_column ' ) - substr_count( $saved, '[/vc_column]' ) ) . "\n";
