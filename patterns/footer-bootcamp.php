<?php
/**
 * Title: Footer: bootcamp
 * Slug: academia/footer-bootcamp
 * Categories: academia_utility, academia, footer
 * Keywords: footer, links, legal
 * Block Types: core/template-part/footer
 * Viewport Width: 1400
 * Description: A four-column footer on the dark ground.
 *
 * @package Academia
 */

?>
<!-- wp:group {"align":"full","backgroundColor":"dark","textColor":"base","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|60"},"elements":{"link":{"color":{"text":"var:preset|color|base"},":hover":{"color":{"text":"var:preset|color|teal-light"}}},"heading":{"color":{"text":"var:preset|color|base"}}}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull has-dark-background-color has-background has-base-color has-text-color has-link-color" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--40);">
<!-- wp:columns {"align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns alignwide">
<!-- wp:column {"width":"34%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column" style="flex-basis:34%;">
<!-- wp:site-title {"level":0,"fontSize":"large"} /-->
<?php if ( get_bloginfo( 'description' ) ) : ?>
<!-- wp:site-tagline {"className":"academia-footer-note"} /-->
<?php else : ?>
<!-- wp:paragraph {"className":"academia-footer-note","fontSize":"small"} -->
<p class="academia-footer-note has-small-font-size">Sixteen weeks, full time, and a job at the end or your money back.</p>
<!-- /wp:paragraph -->
<?php endif; ?>
<!-- wp:social-links {"iconColor":"base","iconColorValue":"#ffffff","className":"is-style-logos-only","size":"has-small-icon-size","layout":{"type":"flex","justifyContent":"left"}} -->
<ul class="wp-block-social-links has-small-icon-size has-icon-color is-style-logos-only">
<!-- wp:social-link {"url":"#","service":"facebook"} /-->
<!-- wp:social-link {"url":"#","service":"x"} /-->
<!-- wp:social-link {"url":"#","service":"instagram"} /-->
<!-- wp:social-link {"url":"#","service":"linkedin"} /-->
</ul>
<!-- /wp:social-links -->
</div>
<!-- /wp:column -->
<!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}}} -->
<div class="wp-block-column">
<!-- wp:heading {"textColor":"base","fontSize":"small"} -->
<h2 class="wp-block-heading has-base-color has-text-color has-small-font-size">Programme</h2>
<!-- /wp:heading -->
<!-- wp:list -->
<ul class="wp-block-list">
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Syllabus', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Cohort dates', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Outcomes', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Mentors', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->
<!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}}} -->
<div class="wp-block-column">
<!-- wp:heading {"textColor":"base","fontSize":"small"} -->
<h2 class="wp-block-heading has-base-color has-text-color has-small-font-size">Admissions</h2>
<!-- /wp:heading -->
<!-- wp:list -->
<ul class="wp-block-list">
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'How to apply', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Financing', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Scholarships', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'FAQ', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->
<!-- wp:column {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}}} -->
<div class="wp-block-column">
<!-- wp:heading {"textColor":"base","fontSize":"small"} -->
<h2 class="wp-block-heading has-base-color has-text-color has-small-font-size">More</h2>
<!-- /wp:heading -->
<!-- wp:list -->
<ul class="wp-block-list">
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Hiring partners', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Blog', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Contact', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li><a href="#"><?php esc_html_e( 'Privacy', 'academia' ); ?></a></li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
<!-- wp:group {"align":"wide","style":{"border":{"top":{"color":"rgba(255,255,255,0.16)","width":"1px","style":"solid"}},"spacing":{"padding":{"top":"var:preset|spacing|40"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group alignwide" style="border-top-color:rgba(255,255,255,0.16);border-top-style:solid;border-top-width:1px;padding-top:var(--wp--preset--spacing--40);">
<!-- wp:paragraph {"className":"academia-footer-note","fontSize":"small"} -->
<p class="academia-footer-note has-small-font-size">&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> <?php echo esc_html( get_bloginfo( 'name' ) ); ?>. <?php esc_html_e( 'All rights reserved.', 'academia' ); ?></p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
