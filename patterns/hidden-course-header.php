<?php
/**
 * Title: Course header
 * Slug: academia/hidden-course-header
 * Inserter: no
 * Categories: academia_courses, academia_utility
 * Keywords: course, header, single, enrol
 * Viewport Width: 1400
 * Description: The opening of a single course page: subject, title, facts, instructor and price.
 *
 * @package Academia
 */


$academia_course = function_exists( 'academia_normalise_course' )
	? academia_normalise_course( get_post(), academia_course_source() )
	: array();
?>
<!-- wp:group {"align":"full","className":"is-style-section-soft","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-soft" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);">
<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center alignwide">
<!-- wp:column {"verticalAlignment":"center","width":"55%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:55%;">
<?php if ( ! empty( $academia_course['categories'] ) ) : ?>
<!-- wp:paragraph -->
<p><span class="academia-chip"><?php echo esc_html( $academia_course['categories'][0]->name ); ?></span></p>
<!-- /wp:paragraph -->
<?php endif; ?>
<!-- wp:post-title {"level":1} /-->
<!-- wp:post-excerpt {"textAlign":"left","fontSize":"large"} /-->
<?php
if ( ! empty( $academia_course ) ) {
	echo academia_course_meta_row( $academia_course );
	echo academia_course_rating( $academia_course );
}
?>
<?php if ( ! empty( $academia_course['instructor'] ) ) : ?>
<!-- wp:paragraph {"textColor":"muted"} -->
<p class="has-muted-color has-text-color"><?php
/* translators: %s: the instructor's name. */
printf( esc_html__( 'Taught by %s', 'academia' ), '<strong>' . esc_html( $academia_course['instructor'] ) . '</strong>' );
?></p>
<!-- /wp:paragraph -->
<?php endif; ?>
<!-- wp:separator {"className":"is-style-wide","backgroundColor":"divider"} -->
<hr class="wp-block-separator has-text-color has-border-color has-divider-border-color has-alpha-channel-opacity has-divider-background-color has-background is-style-wide"/>
<!-- /wp:separator -->
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","verticalAlignment":"center"}} -->
<div class="wp-block-group">
<?php if ( ! empty( $academia_course ) ) { echo academia_course_price( $academia_course ); } ?>
<!-- wp:buttons -->
<div class="wp-block-buttons">
<!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#enrol"><?php esc_html_e( 'Enrol on this course', 'academia' ); ?></a></div>
<!-- /wp:button -->
</div>
<!-- /wp:buttons -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"45%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:45%;">
<?php if ( has_post_thumbnail() ) : ?>
<!-- wp:post-featured-image {"aspectRatio":"4/3","scale":"cover","style":{"border":{"radius":"20px"}}} /-->
<?php endif; ?>
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
