=== Academia ===

Contributors: colorlib
Requires at least: 6.6
Tested up to: 7.0
Requires PHP: 7.4
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Tags: education, blog, portfolio, full-site-editing, block-patterns, block-styles, template-editing, wide-blocks, accessibility-ready, translation-ready, custom-colors, custom-menu, custom-logo, featured-images, threaded-comments, one-column, two-columns, right-sidebar, left-sidebar, rtl-language-support, sticky-post, theme-options

A WordPress block theme for schools, universities, academies and online course
providers.

== Description ==

Academia is a full-site-editing block theme built for teaching institutions: a
course catalogue people can filter and search, instructor profiles, week-by-week
curriculum outlines, admissions steps and enrolment pricing.

Six one-click starter sites cover the shapes an education site actually takes —
an online academy, a university, a primary school, a coding bootcamp, a language
school and an arts studio. Each brings its own palette, typeface, home page,
supporting pages and footer.

= Courses work with or without a plugin =

Academia's course sections read from whatever the site already has, in this
order:

1. **Academia Library** — the free companion plugin. Adds a Course content type
   with levels, durations, lesson counts, prices, instructors and ratings, and
   upgrades the course browser so filtering and sorting happen without a page
   load.
2. **An existing LMS** — Tutor LMS, LifterLMS, Sensei or LearnDash. Their
   courses are read and their fields mapped onto the same cards, so one design
   covers all of them.
3. **Your posts** — with nothing installed, courses fall back to posts in a
   category called "courses". Fewer details on the card, but the theme works on
   a bare install.

The course browser filters correctly with JavaScript disabled. The plugin's
enhancement only removes the page load.

= Design =

* Eight colour palettes and five typography pairings, mixable independently.
* A visitor-facing light/dark toggle that lifts the active palette rather than
  replacing it, so a green site stays green in the dark.
* Every text and control colour meets WCAG AA contrast in both schemes.
* Fluid type and spacing: one scale from a phone to a wide desktop, no
  breakpoint jumps.
* Six self-hosted variable font families — no external requests, no Google
  Fonts dependency.
* Scroll-driven reveal animations using CSS `animation-timeline`, which simply
  do not run where unsupported. Nothing is ever hidden behind JavaScript.
* Honours `prefers-reduced-motion`.

= Blocks and editing =

* 53 patterns: heroes, course grids, subject tiles, curriculum outlines,
  instructors, testimonials, statistics, fee tables, admissions steps, FAQs,
  calls to action and contact sections.
* Nine whole-page starters for Home, Courses, Instructors, Fees, About,
  Contact, Admissions, Syllabus and Outcomes.
* 18 templates including a single-course layout, the course archive and two
  course taxonomy archives.
* WooCommerce-ready.
* Contact sections render whichever form plugin is active — Academia detects ten
  of them and styles the fields without knowing each plugin's class names. A
  theme must not process form submissions, so it never does.

== Installation ==

1. In your WordPress admin, go to Appearance → Themes → Add New → Upload Theme.
2. Upload the Academia zip and click Install Now, then Activate.
3. Academia creates a Home page and a Blog page and points Settings → Reading at
   them. If you already have a static front page, nothing is touched — an admin
   notice offers the setup as a one-click action instead.
4. Optional: install Academia Library for the Course content type, then go to
   Tools → Academia courses to create nine example courses.
5. Optional: go to Appearance → Starter Sites to apply one of the six looks.

== Frequently Asked Questions ==

= Do I need the Academia Library plugin? =

No. Without it, course sections use your posts, and the filter still works with
a page load per change. The plugin adds the course fields (level, duration,
lessons, price, rating) and the no-reload filtering.

= Will I lose my courses if I change theme? =

No. Courses are registered by the plugin, not the theme, so they stay in your
database and stay editable whatever theme is active.

= Can I use my own LMS? =

Yes. Tutor LMS, LifterLMS, Sensei and LearnDash are read automatically. Any
other source can be added with the `academia_course_sources` filter.

= How do I change the colours? =

Appearance → Editor → Styles. Colour and typography can be changed
independently: pick any of the eight palettes and any of the five type
pairings.

= Where is the dark mode toggle? =

In the header — the small sun/moon icon before the call-to-action button. Remove
it from the header template part and its script and stylesheet stop loading
entirely.

== Copyright ==

Academia WordPress Theme, (C) 2026 Colorlib.
Academia is distributed under the terms of the GNU GPL v2 or later.

This theme bundles the following third-party resources:

Manrope
  Copyright (c) 2018 The Manrope Project Authors
  Licence: SIL Open Font License 1.1
  Source: https://github.com/sharanda/manrope

Inter
  Copyright (c) 2016 The Inter Project Authors
  Licence: SIL Open Font License 1.1
  Source: https://github.com/rsms/inter

Fraunces
  Copyright (c) 2019 The Fraunces Project Authors
  Licence: SIL Open Font License 1.1
  Source: https://github.com/undercasetype/Fraunces

Space Grotesk
  Copyright (c) 2020 Florian Karsten
  Licence: SIL Open Font License 1.1
  Source: https://github.com/floriankarsten/space-grotesk

Nunito
  Copyright (c) 2014 The Nunito Project Authors
  Licence: SIL Open Font License 1.1
  Source: https://github.com/googlefonts/nunito

Poppins
  Copyright (c) 2020 Indian Type Foundry
  Licence: SIL Open Font License 1.1
  Source: https://github.com/itfoundry/Poppins

Feather icons (assets/images/icons/*.svg)
  Copyright (c) 2013-2023 Cole Bemis
  Licence: MIT
  Source: https://github.com/feathericons/feather

Photographs (assets/images/*.avif)
  Licence: Unsplash Licence — https://unsplash.com/license
  Source: https://unsplash.com/

== Changelog ==

= 1.0.2 =
* Footer rebuilt: the link lists were rendering with bullets and a 40px indent, and the brand column had no internal spacing. See CHANGELOG.md.

= 1.0.1 =
* Polish pass: alternating section grounds, visible card outlines, grouped card internals, a compact trust bar and an icon scheme toggle. See CHANGELOG.md.

= 1.0.0 =
* Initial release.
