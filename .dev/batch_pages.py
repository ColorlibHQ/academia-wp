#!/usr/bin/env python3
"""Generate Academia's page starters, demo home pages and vertical footers.

Run from the theme root:  python3 .dev/batch_pages.py

A page starter is a list of section references, not one big pattern: a missing
section is skipped rather than breaking the page, and a user can delete one
section in the editor without unpicking the rest.

Sections alternate their ground by role — explanation on the page ground,
proof and prices on the soft ground — so no composition puts four
same-ground sections in a row or two full-bleed bands back to back.
"""

import os
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))

from pgen import write_pattern, pattern_ref  # noqa: E402
import acomp as A  # noqa: E402


def compose(slugs):
    """A page as a list of pattern references."""
    return "\n".join(pattern_ref("academia/" + slug) for slug in slugs)


# --------------------------------------------------------------------------
# Page starters
# --------------------------------------------------------------------------
PAGES = {
    "page-home": ("Home", [
        "hero-academy", "accreditation", "benefits", "courses-featured",
        "subjects", "stats", "testimonials", "pricing", "faq", "cta-enrol",
    ]),
    "page-courses": ("Courses", [
        "course-filter", "subjects", "cta-prospectus", "faq",
    ]),
    "page-instructors": ("Instructors", [
        "instructors", "about-split", "testimonials", "cta-enrol",
    ]),
    "page-pricing": ("Fees", [
        "pricing", "faq", "cta-prospectus",
    ]),
    "page-about": ("About", [
        "about-split", "stats", "accreditation", "instructors", "outcomes", "cta-enrol",
    ]),
    "page-contact": ("Contact", [
        "contact-split", "faq",
    ]),
    "page-admissions": ("Admissions", [
        "admissions-steps", "pricing", "faq", "cta-prospectus",
    ]),
    "page-syllabus": ("Syllabus", [
        "course-curriculum", "instructors", "outcomes", "cta-enrol",
    ]),
    "page-outcomes": ("Outcomes", [
        "outcomes", "stats", "testimonials", "cta-enrol",
    ]),
}

# --------------------------------------------------------------------------
# Demo home pages, one per starter site
# --------------------------------------------------------------------------
DEMOS = {
    "demo-academy": ("Demo: online academy", [
        "hero-academy", "accreditation", "benefits", "courses-featured",
        "subjects", "stats", "testimonials", "pricing", "faq", "cta-enrol",
    ]),
    "demo-university": ("Demo: university", [
        "hero-university", "accreditation", "subjects", "courses-featured",
        "stats", "instructors", "outcomes", "admissions-steps", "cta-enrol",
    ]),
    "demo-school": ("Demo: school", [
        "hero-school", "benefits", "subjects", "instructors",
        "testimonials", "admissions-steps", "faq", "cta-enrol",
    ]),
    "demo-bootcamp": ("Demo: bootcamp", [
        "hero-bootcamp", "outcomes", "course-curriculum", "instructors",
        "stats", "testimonials", "pricing", "faq", "cta-enrol",
    ]),
    "demo-language": ("Demo: language school", [
        "hero-language", "benefits", "courses-featured", "subjects",
        "instructors", "testimonials", "pricing", "cta-enrol",
    ]),
    "demo-studio": ("Demo: arts studio", [
        "hero-studio", "about-split", "courses-featured", "instructors",
        "testimonials", "pricing", "contact-split", "cta-enrol",
    ]),
}


# --------------------------------------------------------------------------
# Footers
# --------------------------------------------------------------------------
def footer(nav_title, links, note, *, contact=None):
    """A vertical's footer.

    Three things the first cut got wrong, all visible at 1:1:

    * The link lists were bare `wp:list` blocks, so they rendered with the
      browser's disc bullets and a 40px indent — a bulleted, indented list on a
      dark ground, which is what made the whole thing look amateur.
    * The column headings were 14px at weight 700 with no tracking, so they
      read as slightly-bolder links rather than as headings.
    * The brand column held only a title, a tagline and four icons, which is
      thin at 420px wide and left the footer with nothing to anchor it.

    So: the lists get a real class and are styled in style.css, the headings get
    an eyebrow treatment, and the brand column carries the contact facts that
    people actually come to a footer looking for.

    The tagline keeps both branches — the site's own when it has one, the
    written line when it does not. Without both, a fresh install shows an empty
    column and a site that has set a tagline shows copy contradicting it.
    """
    contact = contact or [
        ("mail", "hello@example.com"),
        ("phone", "+1 392 3929 210"),
        ("map-pin", "203 Fake St, Mountain View, California"),
    ]

    facts = "".join(
        '<li>{{ICON:%s}}<span>%s</span></li>' % (icon, A.t(text))
        for icon, text in contact
    )

    brand = "\n".join([
        '<!-- wp:site-title {"level":0,"fontSize":"large"} /-->',
        "<?php if ( get_bloginfo( 'description' ) ) : ?>",
        '<!-- wp:site-tagline {"className":"academia-footer-note"} /-->',
        "<?php else : ?>",
        A.para(note, class_name="academia-footer-note", size="small"),
        "<?php endif; ?>",
        A.resolve_icons(A.html_block('<ul class="academia-footer-contact">%s</ul>' % facts)),
        A.social([("facebook", "#"), ("x", "#"), ("instagram", "#"), ("linkedin", "#")],
                 justify="left", size="has-small-icon-size", color="base", value="#ffffff"),
    ])

    # An explicit flex column, not the default flow layout: flow spacing comes
    # from child margins, and the footer resets those to zero, so a blockGap on
    # a flow column has no effect. Measured 1px gaps before this changed.
    columns = [A.column(brand, width="32%", gap="30", layout="flex",
                        orientation="vertical", style_variation="academia-footer-brand")]

    for title, items in links:
        # A real class on the list, because a bare wp:list inherits the
        # browser's bullets and indent.
        body = A.lst([f'<a href="#">{A.t(item)}</a>' for item in items],
                     style=None, class_name="academia-footer-links")
        col = A.heading(title, level=2, size="small", color="base",
                        class_name="academia-footer-heading") + "\n" + body
        columns.append(A.column(col, gap="30", layout="flex", orientation="vertical",
                                style_variation="academia-footer-col"))

    row = A.columns(columns, align="wide", gap="60")

    # Copyright on one side, the legal links on the other, so the bottom bar is
    # a bar rather than a stray line of small print.
    legal_links = A.resolve_icons(A.html_block(
        '<ul class="academia-footer-legal">'
        + "".join('<li><a href="#">%s</a></li>' % A.t(t)
                  for t in ("Privacy", "Terms", "Accessibility"))
        + '</ul>'
    ))

    legal = A.group(
        A.para("&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> "
               + "<?php echo esc_html( get_bloginfo( 'name' ) ); ?>. "
               + A.t("All rights reserved."),
               class_name="academia-footer-note", size="small")
        + "\n" + legal_links,
        layout="flex", justify="space-between", gap="30", wrap="wrap",
        align="wide", border_top=("rgba(255,255,255,0.14)", "1px", "solid"),
        pad={"top": "40"},
    )

    return A.section(
        row + "\n" + legal,
        pad=("70", "40"), gap="60", bg="dark", text="base",
        elements={
            "link": {"color": {"text": "var:preset|color|base"},
                     ":hover": {"color": {"text": "var:preset|color|teal-light"}}},
            "heading": {"color": {"text": "var:preset|color|base"}},
        },
    )


FOOTERS = {
    # The default, referenced by parts/footer.html.
    "footer": ("Footer", footer(
        "Academy",
        [
            ("Courses", ["All courses", "Subjects", "Term dates", "Prospectus"]),
            ("The school", ["About us", "Our tutors", "Outcomes", "Journal"]),
            ("Help", ["Contact", "Fees and funding", "Admissions", "Accessibility"]),
        ],
        "Short, taught courses in design, code and data — small cohorts, practising tutors.",
    )),
    "footer-academy": ("Footer: academy", footer(
        "Academy",
        [
            ("Courses", ["All courses", "Subjects", "Term dates", "Prospectus"]),
            ("The school", ["About us", "Our tutors", "Outcomes", "Journal"]),
            ("Help", ["Contact", "Fees and funding", "Accessibility", "Privacy"]),
        ],
        "Short, taught courses in design, code and data — small cohorts, practising tutors.",
    )),
    "footer-university": ("Footer: university", footer(
        "University",
        [
            ("Study", ["Undergraduate", "Postgraduate", "Research degrees", "Short courses"]),
            ("About", ["The university", "Faculties", "Research", "Campus"]),
            ("Apply", ["Admissions", "Open days", "Fees and funding", "Contact"]),
        ],
        "A teaching and research institution, awarding degrees since 1897.",
    )),
    "footer-school": ("Footer: school", footer(
        "School",
        [
            ("Our school", ["Classes", "Our teachers", "The day", "Term calendar"]),
            ("Parents", ["Admissions", "Uniform", "Lunches", "Newsletter"]),
            ("Visit", ["Book a visit", "Find us", "Contact", "Policies"]),
        ],
        "A primary school for ages four to eleven, in the middle of the village.",
    )),
    "footer-bootcamp": ("Footer: bootcamp", footer(
        "Bootcamp",
        [
            ("Programme", ["Syllabus", "Cohort dates", "Outcomes", "Mentors"]),
            ("Admissions", ["How to apply", "Financing", "Scholarships", "FAQ"]),
            ("More", ["Hiring partners", "Blog", "Contact", "Privacy"]),
        ],
        "Sixteen weeks, full time, and a job at the end or your money back.",
    )),
}


def main():
    print("page starters:")
    for slug, (title, sections) in PAGES.items():
        write_pattern(
            slug,
            title=title,
            cats="academia_page, academia",
            keywords="page, starter, " + title.lower(),
            desc="A complete %s page, built from Academia sections." % title.lower(),
            body=compose(sections),
            block_types="core/post-content",
            post_types="page",
        )
        print("  %s (%d sections)" % (slug, len(sections)))

    print("demo homes:")
    for slug, (title, sections) in DEMOS.items():
        write_pattern(
            slug,
            title=title,
            cats="academia_page, academia",
            keywords="demo, home, starter",
            desc="%s — the home page a starter site builds." % title,
            body=compose(sections),
            inserter=False,
        )
        print("  %s (%d sections)" % (slug, len(sections)))

    print("footers:")
    for slug, (title, body) in FOOTERS.items():
        write_pattern(
            slug,
            title=title,
            cats="academia_utility, academia, footer",
            keywords="footer, links, legal",
            desc="A four-column footer on the dark ground.",
            body=body,
            block_types="core/template-part/footer",
        )
        print("  " + slug)


if __name__ == "__main__":
    main()
