<?php
/**
 * Title: Header
 * Slug: academia/header
 * Categories: header
 * Block Types: core/template-part/header
 * Description: Logo or site title on the left, primary navigation and a call-to-action button on the right.
 *
 * @package Academia
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|30","bottom":"var:preset|spacing|30"}},"border":{"bottom":{"color":"var:preset|color|divider","width":"1px","style":"solid"}}},"backgroundColor":"base","layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-base-background-color has-background" style="border-bottom-color:var(--wp--preset--color--divider);border-bottom-style:solid;border-bottom-width:1px;padding-top:var(--wp--preset--spacing--30);padding-bottom:var(--wp--preset--spacing--30)">
	<!-- wp:group {"align":"wide","className":"academia-header-row","layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
	<div class="wp-block-group alignwide academia-header-row">
		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group">
			<!-- wp:site-logo {"width":40} /-->
			<!-- wp:site-title {"level":0} /-->
		</div>
		<!-- /wp:group -->

		<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap"}} -->
		<div class="wp-block-group">
			<!-- wp:navigation {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}} /-->
	<!-- wp:buttons {"layout":{"type":"flex"}} -->
	<div class="wp-block-buttons">
		<!-- wp:button {"className":"academia-scheme-toggle is-style-academia-ghost","style":{"spacing":{"padding":{"left":"0.7rem","right":"0.7rem","top":"0.7rem","bottom":"0.7rem"}}}} -->
		<div class="wp-block-button academia-scheme-toggle is-style-academia-ghost"><a class="wp-block-button__link wp-element-button" href="#" style="padding-top:0.7rem;padding-right:0.7rem;padding-bottom:0.7rem;padding-left:0.7rem" aria-live="polite"><?php esc_html_e( 'Dark', 'academia' ); ?></a></div>
		<!-- /wp:button -->
	</div>
	<!-- /wp:buttons -->

			<!-- wp:buttons -->
			<div class="wp-block-buttons">
				<!-- wp:button {"style":{"spacing":{"padding":{"top":"0.7rem","bottom":"0.7rem","left":"1.4rem","right":"1.4rem"}}},"fontSize":"small"} -->
				<div class="wp-block-button has-custom-font-size has-small-font-size"><a class="wp-block-button__link wp-element-button" href="#" style="padding-top:0.7rem;padding-right:1.4rem;padding-bottom:0.7rem;padding-left:1.4rem"><?php echo esc_html_x( 'Enrol now', 'Header call-to-action button', 'academia' ); ?></a></div>
				<!-- /wp:button -->
			</div>
			<!-- /wp:buttons -->
		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->
</div>
<!-- /wp:group -->
