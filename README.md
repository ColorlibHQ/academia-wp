# Academia

A WordPress block theme for schools, universities, academies and online course
providers — with a course catalogue people can actually search.

![Academia](screenshot.png)

## What is in here

```
academia/
├── theme.json              design system (generated — edit .dev/build_theme.py)
├── style.css               rules theme.json cannot express + block variations
├── functions.php           supports, block styles, pattern categories, guards
├── inc/
│   ├── courses.php         reads course data from any of five sources
│   ├── front-page-setup.php
│   ├── starter-sites.php   the six one-click looks
│   ├── forms.php           renders whichever form plugin is active
│   ├── scheme.php          visitor light/dark
│   ├── plugin-notice.php   the (dismissible) plugin recommendation
│   └── updates.php         self-hosted updates
├── patterns/               53 patterns (generated — edit .dev/batch_*.py)
├── templates/              18 templates, incl. course single + archives
├── parts/                  header, footer, sidebar
├── styles/                 8 palettes, 5 type presets, 8 looks, 8 section styles
├── assets/                 self-hosted fonts, icons, images, css, js
├── plugin/academia-library/    the companion plugin (ships as its own zip)
└── .dev/                   generators and checks (not shipped)
```

## Courses

Academia's course sections read from whatever the site already has:

| Source | What you get |
| --- | --- |
| **Academia Library** (companion plugin) | Full course fields, and filtering without a page load |
| Tutor LMS, LifterLMS, Sensei, LearnDash | Their courses, mapped onto the same cards |
| Nothing installed | Posts in a `courses` category — fewer card details, still works |

Add another source with the `academia_course_sources` filter.

The course browser works with JavaScript disabled. The plugin's enhancement only
removes the page load — the server always renders the finished, correct result.

## Development

No build step. Python generates the design system and the patterns; everything
else is edited directly.

```bash
python3 .dev/build_theme.py       # theme.json + styles/**
python3 .dev/batch_sections.py    # the education sections
python3 .dev/batch_pages.py       # page starters, demo homes, footers
python3 .dev/batch_course.py      # course single + archive headers

sh .dev/build-zip.sh /tmp/academia-build   # two zips: theme, plugin
```

See [CLAUDE.md](CLAUDE.md) for the conventions, the course architecture and the
traps that are easy to reintroduce.

## Licence

GPL-2.0-or-later. Bundled fonts are OFL 1.1, icons MIT, photographs Unsplash
Licence — full credits in [readme.txt](readme.txt).
