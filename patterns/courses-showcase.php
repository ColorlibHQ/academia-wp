<?php
/**
 * Title: Courses: showcase
 * Slug: academia/courses-showcase
 * Categories: academia_courses, academia
 * Keywords: courses, cards, popular, featured
 * Viewport Width: 1400
 * Description: Three course cards with fixed copy, for a site with no courses entered yet.
 *
 * @package Academia
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"var:preset|spacing|60"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);">
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"constrained","contentSize":"680px"}} -->
<div class="wp-block-group">
<!-- wp:paragraph {"align":"center","textColor":"primary","fontFamily":"heading","fontSize":"small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.12em","textTransform":"uppercase"}}} -->
<p class="has-text-align-center has-primary-color has-text-color has-heading-font-family has-small-font-size" style="font-weight:600;letter-spacing:0.12em;text-transform:uppercase;">Popular courses</p>
<!-- /wp:paragraph -->
<!-- wp:heading {"textAlign":"center"} -->
<h2 class="wp-block-heading has-text-align-center">Where most people start</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"align":"center","textColor":"muted","fontSize":"large"} -->
<p class="has-text-align-center has-muted-color has-text-color has-large-font-size">The three courses students recommend most often.</p>
<!-- /wp:paragraph -->
</div>
<!-- /wp:group -->
<!-- wp:group {"align":"wide","className":"academia-grid-3","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"grid","columnCount":3}} -->
<div class="wp-block-group alignwide academia-grid-3">
<!-- wp:group {"className":"is-style-card academia-course-card","style":{"border":{"radius":"20px"},"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card academia-course-card" style="border-radius:20px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50);">
<!-- wp:group {"className":"academia-course-thumb-wrap","layout":{"type":"constrained"}} -->
<div class="wp-block-group academia-course-thumb-wrap">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","aspectRatio":"16/10","scale":"cover","className":"academia-course-thumb"} -->
<figure class="wp-block-image size-full academia-course-thumb"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/course-1.avif' ) ); ?>" alt="" style="aspect-ratio:16/10;object-fit:cover;"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:group -->
<!-- wp:paragraph -->
<p><span class="academia-chip"><?php esc_html_e( 'Design', 'academia' ); ?></span></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Foundations of interface design</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color">Grids, type and colour — the decisions behind interfaces people trust.</p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<ul class="academia-meta"><li><?php echo academia_icon( 'clock' ); ?><span><?php esc_html_e( '8 weeks', 'academia' ); ?></span></li><li><?php echo academia_icon( 'book-open' ); ?><span><?php esc_html_e( '24 lessons', 'academia' ); ?></span></li><li><?php echo academia_icon( 'bar-chart' ); ?><span><?php esc_html_e( 'Beginner', 'academia' ); ?></span></li></ul>
<!-- /wp:html -->
<!-- wp:html -->
<p class="academia-rating"><span class="academia-stars" role="img" aria-label="<?php esc_attr_e( 'Rated 4.9 out of 5', 'academia' ); ?>">★★★★★</span> <span>4.9 (128)</span></p>
<!-- /wp:html -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group">
<!-- wp:html -->
<p class="academia-price"><?php esc_html_e( '$149', 'academia' ); ?></p>
<!-- /wp:html -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-academia-ghost"} -->
<div class="wp-block-button is-style-academia-ghost"><a class="wp-block-button__link wp-element-button" href="#">View course</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-card academia-course-card","style":{"border":{"radius":"20px"},"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card academia-course-card" style="border-radius:20px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50);">
<!-- wp:group {"className":"academia-course-thumb-wrap","layout":{"type":"constrained"}} -->
<div class="wp-block-group academia-course-thumb-wrap">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","aspectRatio":"16/10","scale":"cover","className":"academia-course-thumb"} -->
<figure class="wp-block-image size-full academia-course-thumb"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/course-2.avif' ) ); ?>" alt="" style="aspect-ratio:16/10;object-fit:cover;"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:group -->
<!-- wp:paragraph -->
<p><span class="academia-chip"><?php esc_html_e( 'Development', 'academia' ); ?></span></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">JavaScript for the web</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color">From the language itself to shipping an app people can actually use.</p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<ul class="academia-meta"><li><?php echo academia_icon( 'clock' ); ?><span><?php esc_html_e( '12 weeks', 'academia' ); ?></span></li><li><?php echo academia_icon( 'book-open' ); ?><span><?php esc_html_e( '36 lessons', 'academia' ); ?></span></li><li><?php echo academia_icon( 'bar-chart' ); ?><span><?php esc_html_e( 'Intermediate', 'academia' ); ?></span></li></ul>
<!-- /wp:html -->
<!-- wp:html -->
<p class="academia-rating"><span class="academia-stars" role="img" aria-label="<?php esc_attr_e( 'Rated 4.9 out of 5', 'academia' ); ?>">★★★★★</span> <span>4.9 (128)</span></p>
<!-- /wp:html -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group">
<!-- wp:html -->
<p class="academia-price"><?php esc_html_e( '$249', 'academia' ); ?></p>
<!-- /wp:html -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-academia-ghost"} -->
<div class="wp-block-button is-style-academia-ghost"><a class="wp-block-button__link wp-element-button" href="#">View course</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
<!-- wp:group {"className":"is-style-card academia-course-card","style":{"border":{"radius":"20px"},"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50","left":"var:preset|spacing|50","right":"var:preset|spacing|50"},"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","orientation":"vertical"}} -->
<div class="wp-block-group is-style-card academia-course-card" style="border-radius:20px;padding-top:var(--wp--preset--spacing--50);padding-right:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);padding-left:var(--wp--preset--spacing--50);">
<!-- wp:group {"className":"academia-course-thumb-wrap","layout":{"type":"constrained"}} -->
<div class="wp-block-group academia-course-thumb-wrap">
<!-- wp:image {"sizeSlug":"full","linkDestination":"none","aspectRatio":"16/10","scale":"cover","className":"academia-course-thumb"} -->
<figure class="wp-block-image size-full academia-course-thumb"><img src="<?php echo esc_url( get_theme_file_uri( 'assets/images/course-3.avif' ) ); ?>" alt="" style="aspect-ratio:16/10;object-fit:cover;"/></figure>
<!-- /wp:image -->
</div>
<!-- /wp:group -->
<!-- wp:paragraph -->
<p><span class="academia-chip"><?php esc_html_e( 'Data', 'academia' ); ?></span></p>
<!-- /wp:paragraph -->
<!-- wp:heading {"level":3,"fontSize":"large"} -->
<h3 class="wp-block-heading has-large-font-size">Analysis with Python</h3>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color">Clean a messy dataset, ask it a question, and defend the answer.</p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<ul class="academia-meta"><li><?php echo academia_icon( 'clock' ); ?><span><?php esc_html_e( '10 weeks', 'academia' ); ?></span></li><li><?php echo academia_icon( 'book-open' ); ?><span><?php esc_html_e( '30 lessons', 'academia' ); ?></span></li><li><?php echo academia_icon( 'bar-chart' ); ?><span><?php esc_html_e( 'Intermediate', 'academia' ); ?></span></li></ul>
<!-- /wp:html -->
<!-- wp:html -->
<p class="academia-rating"><span class="academia-stars" role="img" aria-label="<?php esc_attr_e( 'Rated 4.9 out of 5', 'academia' ); ?>">★★★★★</span> <span>4.9 (128)</span></p>
<!-- /wp:html -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between"}} -->
<div class="wp-block-group">
<!-- wp:html -->
<p class="academia-price"><?php esc_html_e( '$199', 'academia' ); ?></p>
<!-- /wp:html -->
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button {"className":"is-style-academia-ghost"} -->
<div class="wp-block-button is-style-academia-ghost"><a class="wp-block-button__link wp-element-button" href="#">View course</a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
