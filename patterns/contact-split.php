<?php
/**
 * Title: Contact
 * Slug: academia/contact-split
 * Categories: academia_campus, academia, contact
 * Keywords: contact, form, email, phone, address
 * Viewport Width: 1400
 * Description: Contact details beside a form from your form plugin.
 *
 * @package Academia
 */

?>
<!-- wp:group {"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"},"blockGap":"0"}},"layout":{"type":"constrained"}} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);">
<!-- wp:columns {"verticalAlignment":"center","align":"wide","style":{"spacing":{"blockGap":{"top":"var:preset|spacing|60","left":"var:preset|spacing|60"}}}} -->
<div class="wp-block-columns are-vertically-aligned-center alignwide">
<!-- wp:column {"verticalAlignment":"center","width":"44%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:44%;">
<!-- wp:paragraph {"align":"left","textColor":"primary","fontFamily":"heading","fontSize":"small","style":{"typography":{"fontWeight":"600","letterSpacing":"0.12em","textTransform":"uppercase"}}} -->
<p class="has-text-align-left has-primary-color has-text-color has-heading-font-family has-small-font-size" style="font-weight:600;letter-spacing:0.12em;text-transform:uppercase;">Contact</p>
<!-- /wp:paragraph -->
<!-- wp:heading -->
<h2 class="wp-block-heading">Ask us anything</h2>
<!-- /wp:heading -->
<!-- wp:paragraph {"textColor":"muted","fontSize":"large"} -->
<p class="has-muted-color has-text-color has-large-font-size">An advisor answers within one working day. If your question is about a specific course, say which and it goes straight to that tutor.</p>
<!-- /wp:paragraph -->
<!-- wp:html -->
<ul class="academia-meta"><li><?php echo academia_icon( 'mail' ); ?><span><?php esc_html_e( 'hello@example.com', 'academia' ); ?></span></li></ul>
<!-- /wp:html -->
<!-- wp:html -->
<ul class="academia-meta"><li><?php echo academia_icon( 'phone' ); ?><span><?php esc_html_e( '+1 392 3929 210', 'academia' ); ?></span></li></ul>
<!-- /wp:html -->
<!-- wp:html -->
<ul class="academia-meta"><li><?php echo academia_icon( 'map-pin' ); ?><span><?php esc_html_e( '203 Fake St, Mountain View, California', 'academia' ); ?></span></li></ul>
<!-- /wp:html -->
<!-- wp:html -->
<ul class="academia-meta"><li><?php echo academia_icon( 'clock' ); ?><span><?php esc_html_e( 'Monday to Friday, 8am – 8pm', 'academia' ); ?></span></li></ul>
<!-- /wp:html -->
</div>
<!-- /wp:column -->
<!-- wp:column {"verticalAlignment":"center","width":"56%","style":{"spacing":{"blockGap":"var:preset|spacing|30"}}} -->
<div class="wp-block-column is-vertically-aligned-center" style="flex-basis:56%;">
<?php
echo academia_contact_form(
	array(
		'title' => _x( 'Send a message', 'Contact form heading', 'academia' ),
		'email' => 'hello@example.com',
	)
);
?>
</div>
<!-- /wp:column -->
</div>
<!-- /wp:columns -->
</div>
<!-- /wp:group -->
