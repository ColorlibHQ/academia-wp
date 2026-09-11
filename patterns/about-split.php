<?php
/**
 * Title: About the school
 * Slug: academia/about-split
 * Categories: academia_campus, academia_content, academia
 * Keywords: about, story, school, values
 * Viewport Width: 1400
 * Description: A photograph beside the school's story and four commitments.
 *
 * @package Academia
 */

?>
<!-- wp:group {"align":"full","className":"is-style-section-soft","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-soft" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);">
<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center alignwide">
<!-- wp:column {"verticalAlignment":"center","width":"46%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:46%;">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","aspectRatio":"4/3","scale":"cover","style":{"border":{"radius":"20px"}}} -->
<figure class="wp-block-image size-full has-custom-border"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/hero-wide.avif' ) ); ?>" alt="<?php esc_attr_e( 'The main teaching building', 'academia' ); ?>" style="border-radius:20px;aspect-ratio:4/3;object-fit:cover;"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"54%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:54%;">
<!-- wp:paragraph {"align":"left","textColor":"primary","fontFamily":"heading","fontSize":"small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.12em","textTransform":"uppercase"}}} -->
<p class="has-text-align-left has-primary-color has-text-color has-heading-font-family has-small-font-size" style="font-weight:600;letter-spacing:0.12em;text-transform:uppercase;">About us</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">A small school, on purpose</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size">We started in 2009 with one evening class of eleven people. We have grown, but we have kept the thing that made it work: courses small enough that teaching is a conversation.</p>
<!-- /wp:paragraph -->
<!-- wp:list {"className":"is-style-academia-checklist"} -->
<ul class="wp-block-list is-style-academia-checklist">
<!-- wp:list-item -->
<li>Sixteen students to a cohort, never more</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Tutors are practitioners first, teachers second</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Every syllabus is public before you pay</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Fees are flat — no deposit, no admin charge</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
