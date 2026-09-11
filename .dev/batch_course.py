#!/usr/bin/env python3
"""Generate the course single and archive headers.

Run from the theme root:  python3 .dev/batch_course.py

These are hidden patterns: they carry the translatable text for
templates/single-academia_course.html and archive-academia_course.html, which
cannot hold PHP of their own.
"""

import os
import sys

sys.path.insert(0, os.path.dirname(os.path.abspath(__file__)))

from pgen import write_pattern  # noqa: E402
import acomp as A  # noqa: E402


def course_header():
    """The single-course opening.

    Everything a person decides on before reading further — subject, title,
    what it involves, who teaches it, what it costs — above the fold and in
    that order. The facts come from the normalised course array, so the same
    header works whether the data is ours, an LMS's or a plain post's.
    """
    prelude = """
$academia_course = function_exists( 'academia_normalise_course' )
	? academia_normalise_course( get_post(), academia_course_source() )
	: array();
"""

    # The subject chip, only when the course actually has a subject.
    subject = (
        "<?php if ( ! empty( $academia_course['categories'] ) ) : ?>\n"
        + A.chip('<?php echo esc_html( $academia_course[\'categories\'][0]->name ); ?>')
        + "\n<?php endif; ?>"
    )

    meta = (
        "<?php\n"
        "if ( ! empty( $academia_course ) ) {\n"
        "\techo academia_course_meta_row( $academia_course );\n"
        "\techo academia_course_rating( $academia_course );\n"
        "}\n"
        "?>"
    )

    instructor = (
        "<?php if ( ! empty( $academia_course['instructor'] ) ) : ?>\n"
        + A.para(
            '<?php\n'
            '/* translators: %s: the instructor\'s name. */\n'
            'printf( esc_html__( \'Taught by %s\', \'academia\' ), '
            '\'<strong>\' . esc_html( $academia_course[\'instructor\'] ) . \'</strong>\' );\n'
            '?>',
            color="muted",
        )
        + "\n<?php endif; ?>"
    )

    price_row = A.group(
        "<?php if ( ! empty( $academia_course ) ) { echo academia_course_price( $academia_course ); } ?>\n"
        + A.buttons([{"text": A.t("Enrol on this course"), "url": "#enrol"}]),
        layout="flex", justify="space-between", gap="30", wrap="wrap",
        vertical_align="center",
    )

    left = "\n".join([
        subject,
        '<!-- wp:post-title {"level":1} /-->',
        '<!-- wp:post-excerpt {"textAlign":"left","fontSize":"large"} /-->',
        meta,
        instructor,
        A.separator(style="wide", color="divider"),
        price_row,
    ])

    # No featured image means no empty column: the text runs full width.
    right = (
        "<?php if ( has_post_thumbnail() ) : ?>\n"
        + '<!-- wp:post-featured-image {"aspectRatio":"4/3","scale":"cover",'
        + '"style":{"border":{"radius":"20px"}}} /-->\n'
        + "<?php endif; ?>"
    )

    return A.section_std(
        A.split(left, right, left_width="55%", right_width="45%"),
        variation="is-style-section-soft",
        gap="0",
    ), prelude


def course_archive_header():
    return A.section_std(
        A.intro(
            eyebrow_text="Courses",
            title="Everything open for enrolment",
            lead="Filter by subject and level, or search for what you have in mind.",
            align="left",
            content="760px",
        ),
        variation="is-style-section-soft",
        gap="0",
    )


def main():
    body, prelude = course_header()

    write_pattern(
        "hidden-course-header",
        title="Course header",
        cats="academia_courses, academia_utility",
        keywords="course, header, single, enrol",
        desc="The opening of a single course page: subject, title, facts, instructor and price.",
        body=body,
        php_prelude=prelude,
        inserter=False,
    )
    print("  hidden-course-header.php")

    write_pattern(
        "hidden-course-archive-header",
        title="Course archive header",
        cats="academia_courses, academia_utility",
        keywords="course, archive, header",
        desc="The opening of the course archive.",
        body=course_archive_header(),
        inserter=False,
    )
    print("  hidden-course-archive-header.php")


if __name__ == "__main__":
    main()
