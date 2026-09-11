# Publishing scripts for colorlib.com

Run these with wp-cli **as the site user**, from the colorlib.com docroot:

```bash
scp .dev/publish/colorlib-product-page.php hetzner:/tmp/pp.php
ssh hetzner 'cd /var/www/colorlib.com/public \
  && sudo chown web_colorlib_com /tmp/pp.php \
  && sudo -u web_colorlib_com wp --url=https://colorlib.com/wp/ eval-file /tmp/pp.php'
```

| Script | Does |
| --- | --- |
| `colorlib-product-page.php` | Rebuilds the Academia product page (381441). Idempotent; leaves it a **draft**. |
| `colorlib-themes-listing.php` | Adds Academia to the `/wp/themes/` listing (5091). Bails if already listed. |

## The trap that makes these scripts necessary

**WPBakery keeps every `css="…"` rule in the `_wpb_shortcodes_custom_css` post
meta, and only regenerates it when the page is saved through the builder UI.**

Updating `post_content` with `wp_update_post()` leaves that meta at whatever the
*first* save produced, so every `css=` edit after that is silently inert — the
markup says one thing and the page renders another. It cost a round of "why are
these buttons still stacked": the rule was in the content and not in the meta.

Both scripts call `visual_composer()->buildShortcodesCss( $id, 'custom' )` after
saving. **Any script that writes WPBakery content must do the same.**

## Other things worth knowing

- **URLs in a `vc_btn` `link=` attribute must be percent-encoded.** That
  attribute is WPBakery's own `url:…|title:…|target:…` encoding: it splits on
  `|` and then on the **first `:`**, so a raw `https://…` is cut off at
  `https:` and the button renders `href="http://https"` — every button on the
  page dead, while the shortcode text looks perfectly correct. Use
  `rawurlencode()`. Plain `url="…"` attributes, as on `vcex_teaser`, take the
  URL as-is — only `link=` needs encoding.
- **Check the rendered `<a href>`, not the shortcode.** The script asserts
  `dead: 0` by running `do_shortcode()` and scanning the anchors, because
  counting URLs in the content proves nothing about what the browser gets.
- **`vcex_toggle` takes `heading`, not `title`.** With `title` every toggle
  silently renders the shortcode's own placeholder, "Lorem ipsum dolor sit
  amet?". Seven of them shipped that way.
- **`vcex_milestone` with `animated="true"` counts up when scrolled into view**,
  so a full-page screenshot taken without scrolling shows `0`. That is the
  screenshot, not the page — scroll before believing it. Compare against
  Unapp's live page before "fixing" anything here.
- **`equal_height="yes"` equalises the columns, not the teaser inside them.** A
  three-line summary in a row of two-line ones still leaves its card taller.
  Even the copy lengths instead.
- `vc_btn` renders each button in its own block-level container, so several in a
  row stack and the parent's `text-align` never applies. The per-button `css=`
  class carries `display:inline-block` to put them on one line.
- Draft pages 301 for anonymous visitors. To look at one, generate a short-lived
  cookie with `wp_generate_auth_cookie()` and pass it to the browser rather than
  publishing to preview.
