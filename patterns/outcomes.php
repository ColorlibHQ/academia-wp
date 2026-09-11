<?php
/**
 * Title: Outcomes
 * Slug: academia/outcomes
 * Categories: academia_proof, academia
 * Keywords: outcomes, results, employment, salary, report
 * Viewport Width: 1400
 * Description: Published results beside a photograph, with a link to the full report.
 *
 * @package Academia
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);">
<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center alignwide">
<!-- wp:column {"verticalAlignment":"center","width":"52%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:52%;">
<!-- wp:paragraph {"align":"left","textColor":"primary","fontFamily":"heading","fontSize":"small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.12em","textTransform":"uppercase"}}} -->
<p class="has-text-align-left has-primary-color has-text-color has-heading-font-family has-small-font-size" style="font-weight:600;letter-spacing:0.12em;text-transform:uppercase;">Outcomes</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Where last year's cohort went</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size">We publish these every January, including the courses where the numbers are not what we wanted.</p>
<!-- /wp:paragraph -->
<!-- wp:list {"className":"is-style-academia-checklist"} -->
<ul class="wp-block-list is-style-academia-checklist">
<!-- wp:list-item -->
<li>78% in a related role within six months</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>The median reported salary rose by 24%</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>91% would recommend their course unprompted</li>
<!-- /wp:list-item -->
<!-- wp:list-item -->
<li>Six students started a business of their own</li>
<!-- /wp:list-item -->
</ul>
<!-- /wp:list -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-academia-ghost"} -->
<div class="wp-block-button is-style-academia-ghost"><a class="wp-block-button__link wp-element-button" href="#"><?php esc_html_e( 'Read the full report', 'academia' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"48%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:48%;">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","aspectRatio":"4/3","scale":"cover","style":{"border":{"radius":"20px"}}} -->
<figure class="wp-block-image size-full has-custom-border"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/campus.avif' ) ); ?>" alt="<?php esc_attr_e( 'Students in a studio workshop', 'academia' ); ?>" style="border-radius:20px;aspect-ratio:4/3;object-fit:cover;"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
