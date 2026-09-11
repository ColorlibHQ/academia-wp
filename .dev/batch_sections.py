#!/usr/bin/env python3
"""Generate Academia's education section patterns.

Run from the theme root:  python3 .dev/batch_sections.py

Every section is a full-width constrained group with top/bottom padding only —
root padding supplies the gutter. Colours are palette slugs so the eight colour
variations restyle all of it.
"""

import os
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))

from pgen import write_pattern  # noqa: E402
import acomp as A  # noqa: E402

IMG = "assets/images"


def w(slug, **kwargs):
    path = write_pattern(slug, **kwargs)
    print("  " + os.path.basename(path))


# --------------------------------------------------------------------------
# Heroes
# --------------------------------------------------------------------------
def hero_academy():
    """The default hero.

    The HTML template put a 900px-tall teal cover behind a photo cropped to a
    face, with the copy stranded in the bottom-left of an empty field. This is
    a split instead: the claim and the actions sit in a readable column, the
    photograph earns its place beside them, and a small proof card overlaps the
    image so the two halves read as one object.
    """
    left = "\n".join([
        A.chip(A.t("Enrolling for the spring term")),
        A.heading("Learn the skills your next step asks for", level=1),
        A.para(
            "Short, taught courses in design, code and data — built with people "
            "working in the field, and small enough that your tutor knows your name.",
            size="large", color="muted",
        ),
        A.buttons([
            {"text": A.t("Browse courses"), "url": "#courses"},
            {"text": A.t("Talk to an advisor"), "url": "#contact", "style": "academia-ghost"},
        ], gap="30"),
        A.resolve_icons(A.meta_row([
            ("users", A.t("4,800 students")),
            ("award", A.t("Accredited since 2009")),
            ("star", A.t("4.9 average rating")),
        ])),
    ])

    right = A.image(A.uri(f"{IMG}/hero-academy.avif"),
                    A.tattr("A student holding books, smiling"),
                    radius="20px", aspect="4/5", scale="cover", shadow="lifted",
                    class_name="academia-hero-portrait")

    return A.section_std(
        A.split(left, right, left_width="54%", right_width="46%"),
        pad=("70", "70"),
        gap="0",
    )


def hero_page(title, lead, *, image_file="hero-courses.avif"):
    """An inner-page opening.

    Deliberately not a photo cover with the title on top: in the HTML template
    the courses page put white text across a face, which was unreadable at
    every breakpoint. The title sits on the page ground; the photo is a band
    beneath it.
    """
    return A.section_std(
        A.intro(title=title, lead=lead, align="left", content="760px"),
        variation="is-style-section-soft",
        pad=("70", "70"),
        gap="0",
    )


# --------------------------------------------------------------------------
# Benefits / features
# --------------------------------------------------------------------------
def benefits():
    rows = [
        ("monitor", "Taught live, online",
         "Every class is a scheduled session with a tutor, not a video you watch alone. "
         "Recordings stay available for the whole term."),
        ("award", "A certificate that is checked",
         "Assessed coursework, marked by the person who taught you, and a certificate "
         "employers can verify."),
        ("users", "Cohorts of sixteen",
         "Small enough to ask a question and get an answer in the same session, and to "
         "know the people you are studying with."),
    ]
    cards = "\n".join(
        A.icon_card(f"'{icon}'", title, body, variation="is-style-card", expr=True)
        for icon, title, body in rows
    )
    return A.section_std(
        A.intro(eyebrow_text="Why study here", title="Teaching built around people, not playlists",
                lead="Three things we decided not to compromise on.")
        + "\n" + A.grid(cards, cols=3),
    )


def stats():
    figures = [
        ("4,800+", "Students taught"),
        ("96%", "Complete their course"),
        ("320", "Tutors and mentors"),
        ("4.9/5", "Average course rating"),
    ]
    cells = "\n".join(A.stat(number, caption) for number, caption in figures)
    return A.section_std(A.grid(cells, cols=4), variation="is-style-section-soft", gap="0")


# --------------------------------------------------------------------------
# Courses
# --------------------------------------------------------------------------
def courses_featured():
    """The dynamic grid: real courses from whichever source the site has."""
    return A.section_std(
        A.intro(eyebrow_text="Courses", title="Open for enrolment",
                lead="Taught over six to twelve weeks, with one live session a week.")
        + "\n"
        + A.group(A.course_grid_php(number=6, columns_count=3), align="wide", layout="default")
        + "\n"
        + A.buttons([{"text": A.t("See every course"), "url": "#", "style": "academia-ghost"}],
                    justify="center"),
    )


def courses_showcase():
    """Static cards, for a site with no courses entered yet.

    Also what makes the pattern preview in the inserter look like something.
    """
    cards = [
        A.static_course_card(
            image_file="course-1.avif", category="Design", title="Foundations of interface design",
            body="Grids, type and colour — the decisions behind interfaces people trust.",
            duration="8 weeks", lessons="24 lessons", level="Beginner", price="$149"),
        A.static_course_card(
            image_file="course-2.avif", category="Development", title="JavaScript for the web",
            body="From the language itself to shipping an app people can actually use.",
            duration="12 weeks", lessons="36 lessons", level="Intermediate", price="$249"),
        A.static_course_card(
            image_file="course-3.avif", category="Data", title="Analysis with Python",
            body="Clean a messy dataset, ask it a question, and defend the answer.",
            duration="10 weeks", lessons="30 lessons", level="Intermediate", price="$199"),
    ]
    return A.section_std(
        A.intro(eyebrow_text="Popular courses", title="Where most people start",
                lead="The three courses students recommend most often.")
        + "\n" + A.grid("\n".join(cards), cols=3),
    )


def subjects():
    """The subject grid.

    The template had eleven tiles six-across, so the last row left five
    orphans and the counts were all "25 Courses". Nine tiles in a three-up
    grid divides evenly at every breakpoint the utility classes step through.
    """
    tiles = [
        ("figma", "Design", "18 courses"),
        ("code", "Development", "24 courses"),
        ("pie-chart", "Data & analytics", "12 courses"),
        ("briefcase", "Business", "16 courses"),
        ("message-circle", "Languages", "9 courses"),
        ("headphones", "Music & audio", "7 courses"),
        ("target", "Marketing", "11 courses"),
        ("activity", "Health & care", "8 courses"),
        ("globe", "Humanities", "14 courses"),
    ]
    cells = "\n".join(A.level_tile(icon, name, count) for icon, name, count in tiles)
    return A.section_std(
        A.intro(eyebrow_text="Subjects", title="What you can study",
                lead="Nine departments, each with a lead tutor who sets the syllabus.")
        + "\n" + A.grid(cells, cols=3),
    )


def course_filter():
    """The filtered course archive.

    academia_course_filter() renders the interactive version when the plugin is
    active and a plain GET form when it is not, so this section works either
    way.
    """
    return A.section_std(
        A.group(A.course_filter_php(), align="wide", layout="default"),
        gap="50",
    )


def course_curriculum():
    weeks = [
        ("Week 1", "Foundations", [
            ("What interfaces are for", "12 min"),
            ("The grid, and when to break it", "28 min"),
            ("Workshop: audit a screen you use daily", "45 min"),
        ]),
        ("Week 2", "Type and hierarchy", [
            ("Choosing two typefaces", "22 min"),
            ("Scale, rhythm and measure", "26 min"),
            ("Workshop: set a long article", "45 min"),
        ]),
        ("Week 3", "Colour and contrast", [
            ("Building a palette that passes AA", "24 min"),
            ("Dark mode without inverting everything", "18 min"),
            ("Workshop: recolour your audit", "45 min"),
        ]),
        ("Week 4", "Shipping the work", [
            ("Handover that developers can use", "20 min"),
            ("Assessment: your final screen set", "—"),
        ]),
    ]
    return A.section_std(
        A.intro(eyebrow_text="Curriculum", title="Four weeks, week by week",
                lead="Every session is recorded; the workshops are live.")
        + "\n" + A.curriculum(weeks),
    )


# --------------------------------------------------------------------------
# People and proof
# --------------------------------------------------------------------------
def instructors():
    people = [
        ("tutor-1.avif", "Dana Okoye", "Interface design",
         "Fifteen years in product design; leads the design department."),
        ("tutor-2.avif", "Marcus Hale", "Front-end development",
         "Writes the JavaScript syllabus and still ships production code."),
        ("tutor-3.avif", "Priya Raman", "Data & analytics",
         "Former research analyst; teaches the Python and statistics courses."),
        ("tutor-4.avif", "Tomas Bergström", "Business & strategy",
         "Runs the evening business programme and the mentoring scheme."),
    ]
    cards = "\n".join(
        A.instructor_card(image_file, name, role, bio) for image_file, name, role, bio in people
    )
    return A.section_std(
        A.intro(eyebrow_text="Who teaches", title="Tutors who still do the work",
                lead="Every course is written and taught by someone practising in the field.")
        + "\n" + A.grid(cards, cols=4),
    )


def testimonials():
    stories = [
        ("The cohort was the thing I did not expect. Four of us still review each "
         "other's work every month, two years after the course finished.",
         "Rosa Lindqvist", "Product designer, Helsinki", "student-1.avif"),
        ("I came in able to write a little JavaScript and left able to ship. The "
         "assessment was harder than the interview I passed a month later.",
         "Michael Chen", "Front-end developer, Toronto", "student-2.avif"),
        ("Sixteen people means you cannot hide, which is exactly why it worked. "
         "My tutor knew which bit I was stuck on before I said so.",
         "Amara Diallo", "Data analyst, Dakar", "student-3.avif"),
    ]
    cards = "\n".join(A.testimonial(q, n, r, i) for q, n, r, i in stories)
    return A.section_std(
        A.intro(eyebrow_text="Student stories", title="What finishing it was worth")
        + "\n" + A.grid(cards, cols=3),
        variation="is-style-section-soft",
    )


def accreditation():
    """A trust row. Text rather than borrowed logos: shipping recognisable
    marks a user has no right to would be worse than shipping none."""
    marks = [
        ("shield", "Accredited by the National Council for Further Education"),
        ("check-circle", "Registered training provider, no. 4471-B"),
        ("refresh", "Syllabus reviewed every twelve months"),
    ]
    cells = "\n".join(
        A.stack(A.icon_badge(icon, bg="primary") + "\n" + A.para(text, color="muted", size="small"),
                gap="20")
        for icon, text in marks
    )
    return A.section_std(A.grid(cells, cols=3), pad=("60", "60"), gap="0")


def outcomes():
    left = "\n".join([
        A.eyebrow("Outcomes", align="left"),
        A.heading("Where last year's cohort went"),
        A.para("We publish these every January, including the courses where the numbers "
               "are not what we wanted.", color="muted", size="large"),
        A.lst([
            "78% in a related role within six months",
            "The median reported salary rose by 24%",
            "91% would recommend their course unprompted",
            "Six students started a business of their own",
        ], style="academia-checklist"),
        A.buttons([{"text": A.t("Read the full report"), "url": "#", "style": "academia-ghost"}]),
    ])
    right = A.image(A.uri(f"{IMG}/campus.avif"), A.tattr("Students in a studio workshop"),
                    radius="20px", aspect="4/3", scale="cover")
    return A.section_std(A.split(left, right), gap="0")


# --------------------------------------------------------------------------
# Content
# --------------------------------------------------------------------------
def about_split():
    left = A.image(A.uri(f"{IMG}/hero-wide.avif"), A.tattr("The main teaching building"),
                   radius="20px", aspect="4/3", scale="cover")
    right = "\n".join([
        A.eyebrow("About us", align="left"),
        A.heading("A small school, on purpose"),
        A.para("We started in 2009 with one evening class of eleven people. We have grown, "
               "but we have kept the thing that made it work: courses small enough that "
               "teaching is a conversation.", color="muted", size="large"),
        A.lst([
            "Sixteen students to a cohort, never more",
            "Tutors are practitioners first, teachers second",
            "Every syllabus is public before you pay",
            "Fees are flat — no deposit, no admin charge",
        ], style="academia-checklist"),
    ])
    return A.section_std(A.split(left, right, left_width="46%", right_width="54%"), gap="0")


def admissions_steps():
    steps = [
        ("1", "Pick a course", "Read the syllabus and the assessment before you decide. Both are public."),
        ("2", "Short conversation", "Fifteen minutes with a tutor, to check the level is right for you."),
        ("3", "Confirm your place", "Pay the fee in full or in three instalments, whichever suits."),
        ("4", "Start with your cohort", "Terms begin in January, April and September."),
    ]
    cells = "\n".join(A.step(n, title, body) for n, title, body in steps)
    return A.section_std(
        A.intro(eyebrow_text="Admissions", title="Four steps, no entrance exam",
                lead="There is no application fee, and no deadline beyond the term start.")
        + "\n" + A.grid(cells, cols=4),
    )


def faq():
    pairs = [
        ("Do I need experience to start?",
         "For the beginner courses, none at all. Anything marked intermediate lists what it "
         "assumes at the top of the syllabus, and the fifteen-minute conversation before you "
         "enrol exists to check that honestly."),
        ("How much time does a course take?",
         "One live session a week, ninety minutes, plus about three hours of coursework. "
         "Sessions are recorded, so missing one is recoverable."),
        ("What happens if I have to stop?",
         "You keep your place in the next run of the same course at no extra cost, once. "
         "Beyond that we refund the remaining weeks."),
        ("Is the certificate worth anything?",
         "It is assessed and verifiable, which is more than most online certificates. It is "
         "not a degree, and we do not pretend otherwise."),
        ("Can my employer pay?",
         "Yes — we invoice directly and can provide the paperwork most training budgets "
         "need. Ask for it when you enrol."),
    ]
    return A.section_std(
        A.intro(eyebrow_text="Questions", title="Before you enrol")
        + "\n" + A.faq_list(pairs),
        variation="is-style-section-soft",
    )


def pricing():
    plans = [
        A.plan("Single course", "$149", "per course",
               "One course, one term, with everything it includes.",
               ["Live weekly sessions", "All recordings for the term",
                "Marked coursework", "Verified certificate"],
               cta="Choose a course"),
        A.plan("Full year", "$690", "per year",
               "Four courses across the year, at the pace you choose.",
               ["Any four courses", "Priority enrolment", "One-to-one tutor hour each term",
                "Alumni review group", "Verified certificate for each"],
               cta="Enrol for the year", featured=True),
        A.plan("Team", "$120", "per seat",
               "Five seats or more, invoiced to your organisation.",
               ["Any course, any term", "Consolidated invoicing",
                "Progress reports for managers", "A named account contact"],
               cta="Request a quote"),
    ]
    return A.section_std(
        A.intro(eyebrow_text="Fees", title="What it costs",
                lead="Flat fees, paid in full or in three instalments. No deposit.")
        + "\n" + A.grid("\n".join(plans), cols=3),
    )


def blog_latest():
    """Recent posts as a Query Loop.

    sticky is "exclude", not "": a Query Loop with an empty sticky value
    prepends sticky posts on top of perPage, which makes a three-up row render
    four cards.
    """
    query = (
        '<!-- wp:query {"query":{"perPage":3,"pages":0,"offset":0,"postType":"post",'
        '"order":"desc","orderBy":"date","sticky":"exclude","inherit":false},'
        '"align":"wide","layout":{"type":"default"}} -->\n'
        '<div class="wp-block-query alignwide">\n'
        + A.pattern_ref("academia/hidden-posts-grid")
        + '\n</div>\n<!-- /wp:query -->'
    )
    return A.section_std(
        A.intro(eyebrow_text="Journal", title="Notes from the school",
                lead="Teaching notes, syllabus changes and the occasional argument about pedagogy.")
        + "\n" + query,
    )


# --------------------------------------------------------------------------
# Calls to action
# --------------------------------------------------------------------------
def cta_enrol():
    return A.band(
        "The spring term starts on 14 April",
        "Places are allocated when the fee is confirmed. Most courses fill four to six weeks out.",
        [
            {"text": A.t("Browse courses"), "url": "#courses", "bg": "base", "color": "primary"},
            {"text": A.t("Ask a question"), "url": "#contact", "style": "academia-ghost", "color": "base"},
        ],
    )


def cta_prospectus():
    left = "\n".join([
        A.eyebrow("Prospectus", align="left"),
        A.heading("Every syllabus, in one PDF"),
        A.para("Course outlines, assessment criteria, term dates and fees — the same document "
               "our tutors work from.", color="muted", size="large"),
    ])
    right = A.buttons([
        {"text": A.t("Download the prospectus"), "url": "#"},
        {"text": A.t("Request a printed copy"), "url": "#contact", "style": "academia-ghost"},
    ], gap="30")
    return A.section_std(
        A.split(left, right, left_width="60%", right_width="40%"),
        variation="is-style-section-soft", gap="0",
    )


def newsletter():
    """The term-dates mailing list.

    A theme must not process submissions, so this renders whichever form
    plugin is active and falls back to a note when none is.
    """
    inner = "\n".join([
        A.intro(eyebrow_text="Term dates", title="Know when enrolment opens",
                lead="One email when a term opens, and nothing else."),
        A.group(A.contact_form("Join the list", "hello@example.com"),
                layout="constrained", content_size="640px"),
    ])
    return A.section_std(inner, variation="is-style-section-soft")


def contact_split():
    left = "\n".join([
        A.eyebrow("Contact", align="left"),
        A.heading("Ask us anything"),
        A.para("An advisor answers within one working day. If your question is about a "
               "specific course, say which and it goes straight to that tutor.",
               color="muted", size="large"),
        A.resolve_icons(A.meta_row([("mail", A.t("hello@example.com"))])),
        A.resolve_icons(A.meta_row([("phone", A.t("+1 392 3929 210"))])),
        A.resolve_icons(A.meta_row([("map-pin", A.t("203 Fake St, Mountain View, California"))])),
        A.resolve_icons(A.meta_row([("clock", A.t("Monday to Friday, 8am – 8pm"))])),
    ])
    right = A.contact_form("Send a message", "hello@example.com")
    return A.section_std(A.split(left, right, left_width="44%", right_width="56%"), gap="0")


# --------------------------------------------------------------------------
# Write them
# --------------------------------------------------------------------------
SECTIONS = [
    ("hero-academy", "Hero: academy", "academia_hero, academia, banner",
     "hero, education, course, enrol",
     "A split opening: the claim and two actions beside a portrait, with a row of proof facts.",
     hero_academy),

    ("benefits", "Benefits", "academia_features, academia, features",
     "benefits, features, why, teaching",
     "Three icon cards explaining how the teaching works.", benefits),

    ("stats", "Statistics", "academia_proof, academia",
     "stats, numbers, counter, results",
     "Four counting figures on the soft ground.", stats),

    ("courses-featured", "Courses: open for enrolment", "academia_courses, academia",
     "courses, grid, enrolment, catalogue",
     "The live course grid, read from Academia Library, an LMS or your posts.", courses_featured),

    ("courses-showcase", "Courses: showcase", "academia_courses, academia",
     "courses, cards, popular, featured",
     "Three course cards with fixed copy, for a site with no courses entered yet.",
     courses_showcase),

    ("subjects", "Subjects", "academia_courses, academia",
     "subjects, departments, categories, topics",
     "A nine-tile subject grid with course counts.", subjects),

    ("course-filter", "Courses: filter and search", "academia_courses, academia",
     "filter, search, archive, courses, sort",
     "Search, category, level and sort controls above the course grid.", course_filter),

    ("course-curriculum", "Course: curriculum", "academia_courses, academia_content, academia",
     "curriculum, syllabus, lessons, weeks, outline",
     "A week-by-week outline, each week opening to its lessons.", course_curriculum),

    ("instructors", "Instructors", "academia_people, academia",
     "instructors, tutors, teachers, staff, faculty",
     "Four tutor cards: portrait, subject and a line of biography.", instructors),

    ("testimonials", "Student stories", "academia_proof, academia, testimonials",
     "testimonials, students, reviews, stories",
     "Three student stories with ratings and portraits.", testimonials),

    ("accreditation", "Accreditation", "academia_proof, academia",
     "accreditation, trust, registered, quality",
     "A three-part trust row for accreditation and registration facts.", accreditation),

    ("outcomes", "Outcomes", "academia_proof, academia",
     "outcomes, results, employment, salary, report",
     "Published results beside a photograph, with a link to the full report.", outcomes),

    ("about-split", "About the school", "academia_campus, academia_content, academia",
     "about, story, school, values",
     "A photograph beside the school's story and four commitments.", about_split),

    ("admissions-steps", "Admissions steps", "academia_campus, academia, academia_content",
     "admissions, apply, steps, enrolment, how",
     "Four numbered steps from choosing a course to starting a term.", admissions_steps),

    ("faq", "Questions", "academia_content, academia",
     "faq, questions, answers, help",
     "Five questions, each opening to its answer.", faq),

    ("pricing", "Fees", "academia_pricing, academia",
     "pricing, fees, tuition, plans, cost",
     "Three tuition tiers with the middle one highlighted.", pricing),

    ("blog-latest", "Journal", "academia_content, academia, posts",
     "blog, journal, posts, news, articles",
     "The three most recent posts in a wide grid.", blog_latest),

    ("cta-enrol", "Call to action: enrol", "academia_cta, academia, call-to-action",
     "cta, enrol, term, deadline",
     "A closing enrolment prompt on the palette gradient.", cta_enrol),

    ("cta-prospectus", "Call to action: prospectus", "academia_cta, academia",
     "cta, prospectus, download, pdf",
     "A prospectus download prompt on the soft ground.", cta_prospectus),

    ("newsletter", "Term dates list", "academia_cta, academia",
     "newsletter, subscribe, email, term dates",
     "A mailing-list sign-up rendered through whichever form plugin is active.", newsletter),

    ("contact-split", "Contact", "academia_campus, academia, contact",
     "contact, form, email, phone, address",
     "Contact details beside a form from your form plugin.", contact_split),
]


def main():
    print("sections:")
    for slug, title, cats, keywords, desc, fn in SECTIONS:
        w(slug, title=title, cats=cats, keywords=keywords, desc=desc, body=fn())
    print("%d sections written" % len(SECTIONS))


if __name__ == "__main__":
    main()
