<?php
/**
 * Title: Accreditation
 * Slug: academia/accreditation
 * Categories: academia_proof, academia
 * Keywords: accreditation, trust, registered, quality
 * Viewport Width: 1400
 * Description: A three-part trust row for accreditation and registration facts.
 *
 * @package Academia
 */

?>
<!-- wp:group {"align":"full","className":"is-style-section-soft","style":{"spacing":{"padding":{"top":"var:preset|spacing|50","bottom":"var:preset|spacing|50"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull is-style-section-soft" style="padding-top:var(--wp--preset--spacing--50);padding-bottom:var(--wp--preset--spacing--50);">
<!-- wp:group {"align":"wide","layout":{"type":"default"}} -->
<div class="wp-block-group alignwide">
<!-- wp:html -->
<ul class="academia-trustbar"><li><?php echo academia_icon( 'shield' ); ?><span><?php esc_html_e( 'Accredited by the National Council for Further Education', 'academia' ); ?></span></li><li><?php echo academia_icon( 'check-circle' ); ?><span><?php esc_html_e( 'Registered training provider, no. 4471-B', 'academia' ); ?></span></li><li><?php echo academia_icon( 'refresh' ); ?><span><?php esc_html_e( 'Syllabus reviewed every twelve months', 'academia' ); ?></span></li></ul>
<!-- /wp:html -->
</div>
<!-- /wp:group -->
</div>
<!-- /wp:group -->
