/**
 * Capture screenshot.png (1200x900) from the live front page.
 *
 * The test site's own title and its very long menu are replaced in the DOM for
 * the shot: the screenshot has to show the theme, not whatever content the
 * development site happens to carry. Nothing is written back to the site.
 *
 * Usage: node .dev/screenshot.mjs <playwright-path> <site-url> <out-file>
 */
const pwPath = process.argv[2];
const url = process.argv[3] || 'http://local-wp.local/';
const out = process.argv[4] || 'screenshot.png';
const { chromium } = (await import(pwPath)).default;

const b = await chromium.launch();
const p = await (await b.newContext({ viewport: { width: 1200, height: 900 }, deviceScaleFactor: 1 })).newPage();
await p.goto(url, { waitUntil: 'networkidle' });

await p.evaluate(() => {
  const title = document.querySelector('.wp-block-site-title a, .wp-block-site-title');
  if (title) title.textContent = 'Academia';
  const tagline = document.querySelector('.wp-block-site-tagline');
  if (tagline) tagline.textContent = 'Online education and learning';

  // The development site's menu has 30 items over three rows; a theme
  // screenshot should show the header the theme is designed around.
  const nav = document.querySelector('.wp-block-navigation__container');
  if (nav) {
    nav.innerHTML = ['Courses', 'Subjects', 'Instructors', 'Fees', 'About', 'Contact']
      .map(t => `<li class="wp-block-navigation-item wp-block-navigation-link">
        <a class="wp-block-navigation-item__content" href="#">
        <span class="wp-block-navigation-item__label">${t}</span></a></li>`).join('');
  }
  // Anything the dev site injects that is not part of the theme.
  document.querySelectorAll('[class*="premium"], .jetpack-instant-search__widget-area').forEach(el => el.remove());
});

await p.waitForTimeout(600);
await p.screenshot({ path: out, clip: { x: 0, y: 0, width: 1200, height: 900 } });
console.log('wrote', out);
await b.close();
