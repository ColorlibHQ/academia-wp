<?php
/**
 * Title: Hero: bootcamp
 * Slug: academia/hero-bootcamp
 * Categories: academia_hero, academia, banner
 * Keywords: hero, bootcamp, opening
 * Viewport Width: 1400
 * Description: A split opening written for an intensive technical course.
 *
 * @package Academia
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);">
<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center alignwide">
<!-- wp:column {"verticalAlignment":"center","width":"54%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:54%;">
<!-- wp:paragraph -->
<p><span class="academia-chip"><?php esc_html_e( 'Next cohort starts 3 March', 'academia' ); ?></span></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Sixteen weeks. Then a job, or your money back</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size">Full-time, in person, sixteen people to a cohort. You ship four real projects and leave with a portfolio that survives an interview.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#courses"><?php esc_html_e( 'See the syllabus', 'academia' ); ?></a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-academia-ghost"} -->
<div class="wp-block-button is-style-academia-ghost"><a class="wp-block-button__link wp-element-button" href="#contact"><?php esc_html_e( 'Check you are eligible', 'academia' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<!-- wp:html -->
<ul class="academia-meta"><li><?php echo academia_icon( 'trending-up' ); ?><span><?php esc_html_e( '84% hired in six months', 'academia' ); ?></span></li><li><?php echo academia_icon( 'credit-card' ); ?><span><?php esc_html_e( 'Pay after you are hired', 'academia' ); ?></span></li><li><?php echo academia_icon( 'users' ); ?><span><?php esc_html_e( '16 per cohort', 'academia' ); ?></span></li></ul>
<!-- /wp:html -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"46%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:46%;">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","aspectRatio":"4/5","scale":"cover","className":"academia-hero-portrait","style":{"border":{"radius":"20px"},"shadow":"var:preset|shadow|lifted"}} -->
<figure class="wp-block-image size-full has-custom-border academia-hero-portrait"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/course-4.avif' ) ); ?>" alt="<?php esc_attr_e( 'A developer at a laptop', 'academia' ); ?>" style="border-radius:20px;aspect-ratio:4/5;object-fit:cover;box-shadow:var(--wp--preset--shadow--lifted);"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
