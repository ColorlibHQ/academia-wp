# Changelog

All notable changes to Academia are documented here. The format follows
[Keep a Changelog](https://keepachangelog.com/en/1.1.0/), and the project
adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

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
