#!/usr/bin/env python3
"""Education components for Academia, built on the pgen emitters.

Anything shaped like a course, a level, an instructor or a timetable row lives
here so the measurement and the markup stay in one place. Patterns describe
what a section *is*; these decide what it looks like.
"""

from pgen import (  # noqa: F401
    DOM, esc, t, tattr, uri, php, _attrs, sp, spc,
    group, columns, column, heading, para, eyebrow, buttons, image, lst,
    icon_badge, icon_badge_expr, separator, details, social, pattern_ref,
    intro, section, card, stack, card_title, label, icon_card, avatar, grid,
    split, faq_list, section_std, band, php_rows, loop, contact_form,
    CARD_GAP, CARD_PAD, CARD_RADIUS, ROW_GAP, STACK_GAP, SECTION_PAD,
    SECTION_GAP, INTRO_WIDTH, READ_WIDTH, AVATAR_GRID, AVATAR_ROW,
    AVATAR_FEATURE, CARD_TITLE_SIZE,
)

# --------------------------------------------------------------------------
# Chips and meta
# --------------------------------------------------------------------------

def chip(text_html, *, accent=False):
    """A pill. Raw HTML so it can wrap a PHP echo.

    A paragraph with a span is used rather than a bare span: a top-level span
    is not a valid block, and a paragraph containing one is.
    """
    cls = "academia-chip is-accent" if accent else "academia-chip"
    return para(f'<span class="{cls}">{text_html}</span>')


def meta_row(items):
    """Duration / lessons / level under a title.

    items: list of (icon-name, text-html). Emitted as a core/list so it stays
    a list in the editor, with the icons injected by the theme at render time
    would cost a filter — so instead each row is an html block, which is what
    core/html validates as.
    """
    lis = "".join(
        f'<li>{{{{ICON:{icon}}}}}<span>{text}</span></li>' for icon, text in items
    )
    return html_block(f'<ul class="academia-meta">{lis}</ul>')


def html_block(inner):
    """core/html — for markup no core block produces (the meta row, the star
    rating, the filter form). Valid in the editor and left alone by the
    validator."""
    return f"<!-- wp:html -->\n{inner}\n<!-- /wp:html -->"


def icon_svg(name):
    """Inline SVG through the theme helper so it inherits currentColor."""
    return f"<?php echo academia_icon( '{name}' ); ?>"


def resolve_icons(markup):
    """Replace {{ICON:name}} placeholders with the PHP inliner."""
    import re
    return re.sub(r"\{\{ICON:([a-z0-9-]+)\}\}", lambda m: icon_svg(m.group(1)), markup)


# --------------------------------------------------------------------------
# Courses
# --------------------------------------------------------------------------

def course_grid_php(*, number=6, columns_count=3, category="", level="", orderby="date"):
    """The dynamic course grid, as a shortcode.

    A shortcode rather than inline PHP because the front-page setup and the
    starter sites *expand* patterns into post content, where PHP never runs —
    inline PHP would freeze whatever it rendered at activation (on a new site,
    the empty state) into the page permanently. A shortcode is stored as text
    and executed on every render, in both contexts.
    """
    atts = [f'number="{number}"', f'columns="{columns_count}"']
    if category:
        atts.append(f'category="{esc(category)}"')
    if level:
        atts.append(f'level="{esc(level)}"')
    if orderby != "date":
        atts.append(f'orderby="{esc(orderby)}"')
    return shortcode_block("academia_courses " + " ".join(atts))


def shortcode_block(inner):
    """core/shortcode — the one block whose content is run through
    do_shortcode() wherever it is stored."""
    return f"<!-- wp:shortcode -->\n[{inner}]\n<!-- /wp:shortcode -->"


def course_filter_php():
    """The filter bar, as a shortcode — same reason as the grid above. The
    plugin renders the no-reload version; without it this still filters, with
    a page load per change."""
    return shortcode_block("academia_course_browser")


def level_tile(icon, name, count):
    """One tile in the level / subject grid.

    The HTML template put eleven of these in a 6-across grid with a 25-course
    label under each; this keeps the idea and gives it room — icon, name, count,
    and the whole tile is one link target.
    """
    inner = "\n".join([
        icon_badge(icon, bg="primary"),
        heading(name, level=3, size="medium"),
        para(count, color="muted", size="small"),
    ])
    return card(inner, variation="is-style-card-flat", pad="40", gap="20")


def curriculum_week(week, title, lessons):
    """One <details> in the curriculum outline.

    core/details rather than core/accordion: accordion is WP 7.0 only, and the
    curriculum has to render on 6.6.
    """
    items = "".join(
        f'<li><span>{t(lesson)}</span><span class="academia-meta">{t(length)}</span></li>'
        for lesson, length in lessons
    )
    body = html_block(f'<ul class="academia-lessons">{items}</ul>')
    return details(f"{week} &middot; {title}", body)


def curriculum(weeks):
    """The whole outline, in the reading column."""
    inner = "\n".join(curriculum_week(w, title, lessons) for w, title, lessons in weeks)
    return group(
        group(inner, class_name="academia-curriculum", gap="0"),
        layout="constrained", content_size=READ_WIDTH,
    )


# --------------------------------------------------------------------------
# People
# --------------------------------------------------------------------------

def instructor_card(image_file, name, role, bio, *, links=None):
    """An instructor in a grid: portrait, name, subject, one line of bio."""
    parts = [
        avatar(uri(f"assets/images/{image_file}"), "", size=AVATAR_FEATURE),
        heading(name, level=3, size=CARD_TITLE_SIZE),
        para(role, color="primary", size="small", weight="600", letter="0.04em",
             transform="uppercase"),
        para(bio, color="muted"),
    ]
    if links:
        parts.append(social(links, justify="left", size="has-small-icon-size"))
    return card("\n".join(parts), variation="is-style-card", gap="20")


def stat(number, caption):
    """One counting figure. assets/js/counter.js animates it when it scrolls
    into view, and functions.php only enqueues that script when a paragraph
    with this class actually renders."""
    return stack(
        para(number, class_name="academia-count", size="huge", color="primary", align="center")
        + "\n"
        + para(caption, color="muted", size="small", align="center"),
        gap="20",
    )


def testimonial(quote, name, role, image_file):
    """A student story. The portrait and the attribution sit on one row under
    the quote, so a long quote does not push the face off the card."""
    who = columns([
        column(avatar(uri(f"assets/images/{image_file}"), "", size=AVATAR_ROW), width="72px"),
        column(
            para(name, weight="600") + "\n" + para(role, color="muted", size="small"),
            gap="20",
        ),
    ], gap="30", vertical_align="center", is_stacked=False)
    inner = "\n".join([
        html_block(
            '<p class="academia-stars" role="img" aria-label="'
            + tattr("Rated 5 out of 5") + '">★★★★★</p>'
        ),
        para(quote, size="large"),
        who,
    ])
    return card(inner, variation="is-style-card", gap="30")


# --------------------------------------------------------------------------
# Pricing
# --------------------------------------------------------------------------

def plan(name, price, period, blurb, features, *, cta="Enrol now", featured=False):
    """One tuition tier.

    The featured tier uses the highlight section style rather than a bigger
    size, so the row keeps one baseline and the emphasis survives a palette
    change.
    """
    variation = "is-style-highlight" if featured else "is-style-card"
    parts = [
        label(name, color="base" if featured else "primary"),
        html_block(
            f'<p class="academia-price" style="font-size:var(--wp--preset--font-size--huge)">{t(price)}'
            + f'<span style="font-size:var(--wp--preset--font-size--small);font-weight:400"> {t(period)}</span></p>'
        ),
        para(blurb, color="base" if featured else "muted"),
        separator(style="wide", color="divider"),
        lst(features, style="academia-checklist"),
        buttons([{"text": cta, "url": "#", "style": None if featured else "academia-ghost"}],
                margin={"top": "20"}),
    ]
    return card("\n".join(parts), variation=variation, gap="30")


# --------------------------------------------------------------------------
# Steps
# --------------------------------------------------------------------------

def step(number, title, body):
    """A numbered step in an admissions or enrolment sequence."""
    inner = "\n".join([
        html_block(
            f'<p class="academia-count" style="font-size:var(--wp--preset--font-size--x-large);'
            f'color:var(--wp--preset--color--primary)">{number}</p>'
        ),
        heading(title, level=3, size=CARD_TITLE_SIZE),
        para(body, color="muted"),
    ])
    return stack(inner, gap="20")
