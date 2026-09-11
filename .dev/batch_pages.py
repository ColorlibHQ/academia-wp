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
        "hero-academy", "accreditation", "subjects", "courses-featured",
        "stats", "instructors", "outcomes", "admissions-steps", "cta-enrol",
    ]),
    "demo-school": ("Demo: school", [
        "hero-academy", "benefits", "subjects", "instructors",
        "testimonials", "admissions-steps", "faq", "cta-enrol",
    ]),
    "demo-bootcamp": ("Demo: bootcamp", [
        "hero-academy", "outcomes", "course-curriculum", "instructors",
        "stats", "testimonials", "pricing", "faq", "cta-enrol",
    ]),
    "demo-language": ("Demo: language school", [
        "hero-academy", "benefits", "courses-featured", "subjects",
        "instructors", "testimonials", "pricing", "cta-enrol",
    ]),
    "demo-studio": ("Demo: arts studio", [
        "hero-academy", "about-split", "courses-featured", "instructors",
        "testimonials", "pricing", "contact-split", "cta-enrol",
    ]),
}


# --------------------------------------------------------------------------
# Footers
# --------------------------------------------------------------------------
def footer(nav_title, links, note):
    """A vertical's footer.

    The brand column shows the site's own tagline when it has one and the
    written line when it does not — without both branches a fresh install
    shows an empty column, and a site that has set a tagline shows copy that
    contradicts it.
    """
    brand = "\n".join([
        '<!-- wp:site-title {"level":0,"fontSize":"large"} /-->',
        "<?php if ( get_bloginfo( 'description' ) ) : ?>",
        '<!-- wp:site-tagline {"className":"academia-footer-note"} /-->',
        "<?php else : ?>",
        A.para(note, class_name="academia-footer-note", size="small"),
        "<?php endif; ?>",
        A.social([("facebook", "#"), ("x", "#"), ("instagram", "#"), ("linkedin", "#")],
                 justify="left", size="has-small-icon-size", color="base", value="#ffffff"),
    ])

    columns = [A.column(brand, width="34%", gap="30")]

    for title, items in links:
        col = A.heading(title, level=2, size="small", color="base") + "\n" + A.lst(
            [f'<a href="#">{A.t(item)}</a>' for item in items], style=None
        )
        columns.append(A.column(col, gap="20"))

    row = A.columns(columns, align="wide", gap="60")

    legal = A.group(
        A.para("&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> "
               + "<?php echo esc_html( get_bloginfo( 'name' ) ); ?>. "
               + A.t("All rights reserved."),
               class_name="academia-footer-note", size="small"),
        layout="flex", justify="space-between", gap="30", wrap="wrap",
        align="wide", border_top=("rgba(255,255,255,0.16)", "1px", "solid"),
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
