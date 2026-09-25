# Changelog

All notable changes to Academia are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and the project
adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## 1.1.1

- Update requests no longer name the site. WordPress's default User-Agent carries the site address; the update check and core's package download to updates.colorlib.com now send only the theme and WordPress versions, so the one-way site identifier is the only thing that tells installs apart.

## [1.0.0] — 2026-09-11

Initial release. A WordPress block theme for schools, universities, academies
and online course providers, built from the Academia HTML template and rebuilt
rather than ported.

### Added

- **Full-site-editing block theme** on theme.json v3: 54 patterns, 18
  templates, 3 template parts. No build step — every file ships as authored.
- **Course architecture that works with or without a plugin.** Course sections
  read from Academia Library, from Tutor LMS / LifterLMS / Sensei / LearnDash,
  or from plain posts in a `courses` category, all through one adapter and one
  card design. Extensible with the `academia_course_sources` filter.
- **Academia Library companion plugin**: a Course content type with subject and
  level taxonomies and eight fields (duration, lessons, level, price, offer
  price, instructor, rating, reviews), all REST-exposed and individually
  sanitised; an admin panel and sortable list columns; and nine demo courses on
  one click from Tools → Academia courses.
- **A course browser that filters, searches, sorts and paginates without a page
  load** — and filters correctly with JavaScript disabled, because the server
  renders the finished result and the script only removes the navigation.
- **Six starter sites**: online academy, university, school, coding bootcamp,
  language school and arts studio. Each applies its own palette, typeface, home
  page, supporting pages and footer, and never deletes user content.
- **Design system**: 8 colour palettes × 5 typography pairings, mixable
  independently, plus 8 curated looks. Fluid type and spacing scales, three
  radii, and shadows built with `color-mix()` on palette colours so they follow
  whichever palette is active.
- **Visitor light/dark toggle** that lifts the active palette rather than
  replacing it, with the choice remembered and applied before first paint so the
  page never flashes the wrong scheme.
- **Six self-hosted variable font families** (Manrope, Inter, Fraunces, Space
  Grotesk, Nunito, Poppins) with per-subset `unicodeRange` — no external
  requests.
- **Education sections**: heroes, a live course grid, subject tiles, a
  week-by-week curriculum outline, instructor cards, student stories,
  accreditation, published outcomes, admissions steps, fee tiers, FAQs,
  prospectus and enrolment calls to action, and a contact section.
- **Nine page starters** — Home, Courses, Instructors, Fees, About, Contact,
  Admissions, Syllabus, Outcomes.
- **Course templates**: a single-course layout, the course archive, and archives
  for the subject and level taxonomies.
- Front page and Blog page created on activation, automatically only when the
  site has no static front page; otherwise offered as a one-click admin action.
- Contact sections render whichever of ten form plugins is active, styled
  without depending on any plugin's class names. The theme never processes a
  submission.
- WooCommerce support, with the product grid's column tracks set explicitly so
  the theme's wider gap does not silently drop it from three columns to two.
- Self-hosted updates through the `Update URI` header, using WordPress's own
  update check — no cron, no bespoke updater UI. What it transmits is documented
  in full in `inc/updates.php` and can be disabled with one filter.
- Translation-ready: 461 theme strings and 108 plugin strings, with `.pot` files.

### Accessibility

- Every text and control colour meets **WCAG AA** contrast in both light and
  dark schemes. The HTML template's brand teal was 2.63:1 on white and its body
  copy 2.68:1; both now pass. Verified numerically, not by eye.
- `focus-visible` rings on every interactive element, not only links and buttons.
- `prefers-reduced-motion` honoured; the scroll-driven reveals are opt-in by
  browser support and never hide content.
- `aria-pressed` and an action-naming label on the scheme toggle;
  `role="status"` on the course count so a filter change is announced.

### Performance

- No jQuery, and none of the HTML template's four JavaScript dependencies: AOS
  is replaced by CSS `animation-timeline`, tiny-slider by native scroll-snap,
  GLightbox by the core lightbox, Leaflet removed.
- The only scripts that load are the ~70-line filter enhancement, the scheme
  toggle where a toggle is present, and the statistics counter where a counting
  figure actually renders.
- Imagery ships as AVIF, sized to the slot each fills — 568 KB for nineteen
  images.

## [1.0.1] — 2026-09-11

A polish pass after reviewing the built theme at 1:1. The design system was
sound; its application was not.

### Fixed

- **Sections had no boundaries.** The home page put five consecutive sections on
  the same white ground, so the page read as one undifferentiated column.
  Sections now declare a role and `.dev/grounds.py` derives an alternating
  ground from it, failing the build on two consecutive sections sharing a
  ground, two adjacent full-bleed bands, or a long page with no band at all.
  All 15 compositions pass.
- **Card outlines were invisible.** The divider colour was 1.26:1 on white, so a
  grid of cards read as floating images with loose text beneath. It is now
  1.55:1, and the card shadow is present rather than theoretical.
- **Nothing grouped inside a card.** Every element sat at the same distance from
  its neighbour, so the eye had no hierarchy to follow. The course card is now
  three groups — identity, facts, and a hairline-separated foot carrying the
  price and the action — with tight gaps inside a group and wide gaps between.
- **The accreditation row** was three orphaned icon badges above stacked text
  with 190px of dead space beneath it. It is now a compact trust bar: icons
  inline with their text, items separated by rules, tight padding.
- **The scheme toggle** was a bordered pill reading "Dark" next to the primary
  call to action, competing with it and reading as a status rather than a
  control. It is now a quiet 40px icon button whose two icons cross-fade, with
  `aria-pressed` and an action-naming `aria-label`.

### Changed

- The `courses-showcase` pattern is removed. Its hand-built static cards were a
  second card design that had to be kept in visual sync with the real one; the
  dynamic grid and the plugin's demo importer cover the same need.
- Starter sites no longer create a page whose slug shadows a registered
  post-type archive — the academy starter's "Courses" page was unreachable
  behind the course archive. The menu links to the archive instead.

## [1.0.2] — 2026-09-11

### Fixed

- **The footer link lists rendered with the browser's disc bullets and a 40px
  indent.** They were bare `wp:list` blocks with no class, so a dark footer
  showed three bulleted, indented lists — the single thing that made it look
  unfinished. They now have a real class and are styled properly.
- **The footer's brand column had no internal spacing at all** — measured gaps
  of 1px, -1px and 1px between the site title, tagline, contact facts and
  social row. WordPress's flow layout spaces children with margins, and the
  footer resets those to zero, so the column's `blockGap` had no effect. Both
  the brand and the link columns are now explicit flex columns with real gaps.
- **Column headings read as slightly-bolder links** at 14px/700 with no
  tracking. They are now a proper eyebrow: small, uppercase, tracked, and
  quieter than the links beneath them.
- **The default footer was still Unapp's**, including its SaaS copy about "one
  calm workspace for planning, files and conversations" — which is what a fresh
  install showed before applying a starter. It is now generated from the same
  function as the vertical footers, so there is one implementation.
- **The starter header logic could never match its own default.** It compared
  a starter's CTA against the literal `Get Premium` while the header pattern
  had been changed to `Enrol now`, so every starter wrote a customised header
  template part it did not need — including the academy starter, whose CTA *is*
  the default.
- Four footer columns inside 782px left the link columns ~119px wide, wrapping
  "Fees and funding" over two lines. Between the stacking breakpoint and 1000px
  the brand now takes a full row and the three link columns share the next.
- The sidebar's call to action said "Start free trial".

### Added

- Contact facts (email, phone, address) in the footer's brand column, with
  palette-coloured icons — the column previously held only a title, a tagline
  and four 16px social icons, which left the footer with nothing to anchor it.
- A bottom bar with the copyright on one side and Privacy / Terms /
  Accessibility on the other, separated by thin rules.

## [1.0.3] — 2026-09-11

### Fixed

- **A 20px strip of page background sat between the header and the content, and
  between the content and the footer.** `.wp-site-blocks` is a flow container,
  so WordPress applies the root `blockGap` as `margin-block-start` on every
  top-level region. It was invisible wherever a white section happened to sit
  next to it and an obvious white band where the gradient call to action met the
  dark footer. The regions are flush now, at every breakpoint, and sections keep
  supplying their own padding.
- **Templates opened tighter than they closed.** Every content template used
  64px of top padding against 96px at the bottom — an asymmetry inherited from
  Unapp — while the section patterns and the course templates used 96/96. So a
  blog or search page opened on a different rhythm from every section beneath
  it. All fourteen templates are 96/96 now, matching `SECTION_PAD`.

## [1.0.4] — 2026-09-11

### Fixed

- **The companion plugin could not be activated on a site running Academia.**
  Both the theme and the plugin declared `academia_course_filter()`, on the
  reasoning that plugins load before a theme's `functions.php` so the plugin's
  version would always win. That holds for an ordinary request and fails on the
  one that matters: activating a plugin happens in a request where the theme is
  *already* loaded, so the plugin's declaration hit an existing function and
  fataled with "Cannot redeclare". The theme now owns a single
  `academia_course_filter()` entry point and the plugin swaps the renderer
  through the new `academia_course_filter_renderer` filter, which cannot collide
  and does not depend on load order. Verified in both activation orders and with
  the plugin off.

### Added

- The plugin now implements `update_plugins_updates.colorlib.com`. It had
  declared an `Update URI` header since 1.0.0 with nothing acting on it, so it
  advertised an update endpoint and could never have offered an update.

## [1.1.0] — 2026-09-11

### Added

- **Every starter site now has its own hero.** All six opened with the online
  academy's copy, so a university read as an academy and a primary school
  advertised "courses in design, code and data" — the same "every niche owns its
  whole page" failure that bit Unapp 2.3. There are now six heroes with their
  own headline, lead, calls to action, proof facts and photograph, built from one
  parameterised `hero()` so the measurements stay shared.

### Changed

- The six starters now read as six products: each pairs its own hero with its
  own palette, typeface, navigation and header call to action — teal/Manrope
  "Browse courses" for the academy through to slate/Space Grotesk "Join a
  cohort" for the bootcamp.

