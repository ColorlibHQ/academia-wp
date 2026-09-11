<?php
/**
 * Title: Fees
 * Slug: academia/pricing
 * Categories: academia_pricing, academia
 * Keywords: pricing, fees, tuition, plans, cost
 * Viewport Width: 1400
 * Description: Three tuition tiers with the middle one highlighted.
 *
 * @package Academia
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"var:preset|spacing|60"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);">
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"680px"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"align":"center","textColor":"primary","fontFamily":"heading","fontSize":"small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.12em","textTransform":"uppercase"}}} -->
<p class="has-text-align-center has-primary-color has-text-color has-heading-font-family has-small-font-size" style="font-weight:600;letter-spacing:0.12em;text-transform:uppercase;">Fees</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">What it costs</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"large"} -->
<p class="has-text-align-center has-muted-color has-text-color has-large-font-size">Flat fees, paid in full or in three instalments. No deposit.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"align":"wide","className":"academia-grid-3","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":3}} -->
<div class="wp-block-group alignwide academia-grid-3">
<!-- wp:group {"className":"is-style-card","style":{"border":{"radius":"20px"},"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card" style="border-radius:20px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50);">
<!-- wp:paragraph {"textColor":"primary","fontSize":"small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.06em","textTransform":"uppercase"}}} -->
<p class="has-primary-color has-text-color has-small-font-size" style="font-weight:600;letter-spacing:0.06em;text-transform:uppercase;">Single course</p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<p class="academia-price" style="font-size:var(--wp--preset--font-size--huge)"><?php esc_html_e( '$149', 'academia' ); ?><span style="font-size:var(--wp--preset--font-size--small);font-weight:400"> <?php esc_html_e( 'per course', 'academia' ); ?></span></p>
<!-- /wp:html -->
<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color">One course, one term, with everything it includes.</p>
<!-- /wp:paragraph -->
<!-- wp:separator {"className":"is-style-wide","backgroundColor":"divider"} -->
<hr class="wp-block-separator has-text-color has-border-color has-divider-border-color has-alpha-channel-opacity has-divider-background-color has-background is-style-wide"/>
<!-- /wp:separator -->
<!-- wp:list {"className":"is-style-academia-checklist"} -->
<ul class="wp-block-list is-style-academia-checklist">
<!-- wp:list-item -->
<li>Live weekly sessions</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>All recordings for the term</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Marked coursework</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Verified certificate</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--20);">
<!-- wp:button {"className":"is-style-academia-ghost"} -->
<div class="wp-block-button is-style-academia-ghost"><a class="wp-block-button__link wp-element-button" href="#">Choose a course</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-highlight","style":{"border":{"radius":"20px"},"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-highlight" style="border-radius:20px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50);">
<!-- wp:paragraph {"textColor":"base","fontSize":"small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.06em","textTransform":"uppercase"}}} -->
<p class="has-base-color has-text-color has-small-font-size" style="font-weight:600;letter-spacing:0.06em;text-transform:uppercase;">Full year</p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<p class="academia-price" style="font-size:var(--wp--preset--font-size--huge)"><?php esc_html_e( '$690', 'academia' ); ?><span style="font-size:var(--wp--preset--font-size--small);font-weight:400"> <?php esc_html_e( 'per year', 'academia' ); ?></span></p>
<!-- /wp:html -->
<!-- wp:paragraph {"textColor":"base"} -->
<p class="has-base-color has-text-color">Four courses across the year, at the pace you choose.</p>
<!-- /wp:paragraph -->
<!-- wp:separator {"className":"is-style-wide","backgroundColor":"divider"} -->
<hr class="wp-block-separator has-text-color has-border-color has-divider-border-color has-alpha-channel-opacity has-divider-background-color has-background is-style-wide"/>
<!-- /wp:separator -->
<!-- wp:list {"className":"is-style-academia-checklist"} -->
<ul class="wp-block-list is-style-academia-checklist">
<!-- wp:list-item -->
<li>Any four courses</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Priority enrolment</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>One-to-one tutor hour each term</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Alumni review group</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Verified certificate for each</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--20);">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">Enrol for the year</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-card","style":{"border":{"radius":"20px"},"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card" style="border-radius:20px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50);">
<!-- wp:paragraph {"textColor":"primary","fontSize":"small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.06em","textTransform":"uppercase"}}} -->
<p class="has-primary-color has-text-color has-small-font-size" style="font-weight:600;letter-spacing:0.06em;text-transform:uppercase;">Team</p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<p class="academia-price" style="font-size:var(--wp--preset--font-size--huge)"><?php esc_html_e( '$120', 'academia' ); ?><span style="font-size:var(--wp--preset--font-size--small);font-weight:400"> <?php esc_html_e( 'per seat', 'academia' ); ?></span></p>
<!-- /wp:html -->
<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color">Five seats or more, invoiced to your organisation.</p>
<!-- /wp:paragraph -->
<!-- wp:separator {"className":"is-style-wide","backgroundColor":"divider"} -->
<hr class="wp-block-separator has-text-color has-border-color has-divider-border-color has-alpha-channel-opacity has-divider-background-color has-background is-style-wide"/>
<!-- /wp:separator -->
<!-- wp:list {"className":"is-style-academia-checklist"} -->
<ul class="wp-block-list is-style-academia-checklist">
<!-- wp:list-item -->
<li>Any course, any term</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Consolidated invoicing</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Progress reports for managers</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>A named account contact</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
<!-- wp:buttons {"style":{"spacing":{"margin":{"top":"var:preset|spacing|20"}}}} -->
<div class="wp-block-buttons" style="margin-top:var(--wp--preset--spacing--20);">
<!-- wp:button {"className":"is-style-academia-ghost"} -->
<div class="wp-block-button is-style-academia-ghost"><a class="wp-block-button__link wp-element-button" href="#">Request a quote</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
