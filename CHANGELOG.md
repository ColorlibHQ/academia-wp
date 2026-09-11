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
