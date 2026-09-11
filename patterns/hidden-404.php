<?php
/**
 * Title: 404 content
 * Slug: academia/hidden-404
 * Inserter: no
 * Description: Big 404, friendly message, search form and a button back home.
 *
 * @package Academia
 */

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"constrained","contentSize":"640px"}} -->
<div class="wp-block-group">
	<!-- wp:paragraph {"align":"center","style":{"typography":{"fontWeight":"600","lineHeight":"1","fontSize":"clamp(4rem, 12vw, 8rem)"}},"textColor":"primary","fontFamily":"heading"} -->
	<p class="has-text-align-center has-primary-color has-text-color has-heading-font-family" style="font-size:clamp(4rem, 12vw, 8rem);font-weight:600;line-height:1">404</p>
	<!-- /wp:paragraph -->
	<!-- wp:heading {"textAlign":"center","level":1,"fontSize":"huge"} -->
	<h1 class="wp-block-heading has-text-align-center has-huge-font-size"><?php esc_html_e( 'Page not found', 'academia' ); ?></h1>
	<!-- /wp:heading -->
	<!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"large"} -->
	<p class="has-text-align-center has-muted-color has-text-color has-large-font-size"><?php esc_html_e( 'The page you are looking for may have been moved, renamed or never existed. Try a search, or head back to the start.', 'academia' ); ?></p>
	<!-- /wp:paragraph -->
	<!-- wp:pattern {"slug":"academia/hidden-search"} /-->
	<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|30"}}},"layout":{"type":"flex","justifyContent":"center"}} -->
	<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--30)">
		<!-- wp:button {"className":"is-style-outline"} -->
		<div class="wp-block-button is-style-outline"><a class="wp-block-button__link wp-element-button" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php echo esc_html_x( 'Back to homepage', 'Button text', 'academia' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
