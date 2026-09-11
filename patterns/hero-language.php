<?php
/**
 * Title: Hero: language school
 * Slug: academia/hero-language
 * Categories: academia_hero, academia, banner
 * Keywords: hero, language, opening
 * Viewport Width: 1400
 * Description: A split opening written for a language school.
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
<p><span class="academia-chip"><?php esc_html_e( 'Free placement test', 'academia' ); ?></span></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":1} -->
<h1 class="wp-block-heading">Speak it by the end of term, not the end of the book</h1>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size">A1 to C2 in eight languages, taught by native speakers in classes of nine. Two evenings a week, or an intensive fortnight.</p>
<!-- /wp:paragraph -->
<!-- wp:buttons {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#courses"><?php esc_html_e( 'Take the placement test', 'academia' ); ?></a></div>
<!-- /wp:button -->
<!-- wp:button {"className":"is-style-academia-ghost"} -->
<div class="wp-block-button is-style-academia-ghost"><a class="wp-block-button__link wp-element-button" href="#contact"><?php esc_html_e( 'See the timetable', 'academia' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
<!-- wp:html -->
<ul class="academia-meta"><li><?php echo academia_icon( 'message-circle' ); ?><span><?php esc_html_e( '8 languages', 'academia' ); ?></span></li><li><?php echo academia_icon( 'users' ); ?><span><?php esc_html_e( '9 to a class', 'academia' ); ?></span></li><li><?php echo academia_icon( 'award' ); ?><span><?php esc_html_e( 'Exam centre for DELE and DELF', 'academia' ); ?></span></li></ul>
<!-- /wp:html -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"46%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:46%;">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","aspectRatio":"4/5","scale":"cover","className":"academia-hero-portrait","style":{"border":{"radius":"20px"},"shadow":"var:preset|shadow|lifted"}} -->
<figure class="wp-block-image size-full has-custom-border academia-hero-portrait"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/course-2.avif' ) ); ?>" alt="<?php esc_attr_e( 'A tutor teaching a small class', 'academia' ); ?>" style="border-radius:20px;aspect-ratio:4/5;object-fit:cover;box-shadow:var(--wp--preset--shadow--lifted);"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
