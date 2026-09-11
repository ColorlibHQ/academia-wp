<?php
/**
 * Title: Author header
 * Slug: academia/hidden-author-header
 * Inserter: no
 * Description: Author avatar, name and biography above the author's posts.
 *
 * @package Academia
 */

?>
<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|30","margin":{"bottom":"var:preset|spacing|60"}}},"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}} -->
<div class="wp-block-group" style="margin-bottom:var(--wp--preset--spacing--60)">
	<!-- wp:avatar {"size":96,"style":{"border":{"radius":"999px"}}} /-->
	<!-- wp:query-title {"type":"archive","showPrefix":false,"textAlign":"center","level":1,"fontSize":"huge"} /-->
	<!-- wp:term-description {"textAlign":"center","textColor":"muted"} /-->
</div>
<!-- /wp:group -->
