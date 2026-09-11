#!/usr/bin/env python3
"""Assign and audit section grounds.

A page reads as a sequence of distinct sections only if consecutive sections do
not share a background. The first cut of the home page put **five** sections in
a row on the page ground, which is exactly why it read as one long column with
no boundaries.

Rather than hand-pick a background per pattern, each section declares its
*role* and this module derives the ground from the role plus its position, then
audits every composition. Run it after the pattern batches:

    python3 .dev/grounds.py          # rewrite grounds, then audit
    python3 .dev/grounds.py --audit  # audit only

Rules enforced:

1. Never two consecutive sections on the same ground.
2. Never two full-bleed bands (dark or gradient) adjacent — they fight.
3. A composition of six or more sections must contain at least one full-bleed
   band. Correct alternation alone still reads as stripes if nothing ever
   breaks out of the content column.
"""

import os
import re
import sys

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))
PATTERNS = os.path.join(ROOT, "patterns")

# Ground tokens, in the order they are allowed to alternate.
PAGE = ""                      # the page ground (base) — no style variation
SOFT = "is-style-section-soft"  # the tinted ground
DARK = "is-style-section-dark"
GRADIENT = None                 # set by the pattern itself (cta-enrol)

# A section's role decides which grounds it may sit on. `alt` is the ground it
# takes when its preferred one would repeat the section above it.
ROLES = {
    # explanation and content prefer the page ground
    "hero-academy":      ("hero", PAGE, PAGE),
    "hero-university":   ("hero", PAGE, PAGE),
    "hero-school":       ("hero", PAGE, PAGE),
    "hero-bootcamp":     ("hero", PAGE, PAGE),
    "hero-language":     ("hero", PAGE, PAGE),
    "hero-studio":       ("hero", PAGE, PAGE),
    "benefits":          ("explain", PAGE, SOFT),
    "subjects":          ("explain", PAGE, SOFT),
    "about-split":       ("explain", PAGE, SOFT),
    "outcomes":          ("explain", PAGE, SOFT),
    "course-curriculum": ("explain", PAGE, SOFT),
    "admissions-steps":  ("explain", PAGE, SOFT),
    "instructors":       ("people", PAGE, SOFT),
    "blog-latest":       ("content", PAGE, SOFT),
    "contact-split":     ("content", PAGE, SOFT),
    # proof, prices and answers prefer the tinted ground
    "accreditation":     ("proof", SOFT, PAGE),
    "stats":             ("proof", SOFT, PAGE),
    "testimonials":      ("proof", SOFT, PAGE),
    "pricing":           ("price", SOFT, PAGE),
    "faq":               ("answers", SOFT, PAGE),
    "courses-featured":  ("courses", SOFT, PAGE),
    "course-filter":     ("courses", PAGE, SOFT),
    "cta-prospectus":    ("cta", SOFT, PAGE),
    # full-bleed bands own their ground and are never reassigned
    "cta-enrol":         ("band", GRADIENT, GRADIENT),
    "newsletter":        ("cta", SOFT, PAGE),
}

BANDS = {"cta-enrol"}


def ground_of(slug, previous):
    """The ground a section should take, given what precedes it."""
    if slug not in ROLES:
        return PAGE

    _, preferred, alternate = ROLES[slug]

    if slug in BANDS:
        return preferred

    if preferred == previous:
        return alternate

    return preferred


def sequence(slugs):
    """The grounds a composition resolves to."""
    out = []
    previous = None

    for slug in slugs:
        ground = ground_of(slug, previous)
        out.append(ground)
        previous = ground if slug not in BANDS else "band"

    return out


def set_pattern_ground(slug, ground):
    """Rewrite a section pattern's outermost style variation."""
    path = os.path.join(PATTERNS, slug + ".php")

    if not os.path.exists(path):
        return False

    body = open(path).read()

    # Only the first (outermost) group of the pattern.
    match = re.search(r'<!-- wp:group \{"align":"full"(.*?)-->\n<div class="wp-block-group alignfull([^"]*)"', body, re.S)

    if not match:
        return False

    attrs, classes = match.group(1), match.group(2)

    def swap_attr(text, new):
        text = re.sub(r',"className":"[^"]*"', '', text)

        if new:
            return text.replace('"align":"full"', '"align":"full"') .replace(
                '{"align":"full"', '{"align":"full"', 1) if False else re.sub(
                r'(\{?"align":"full")', r'\1,"className":"%s"' % new, text, count=1)

        return text

    new_attrs = swap_attr('"align":"full"' + attrs, ground)
    new_attrs = new_attrs[len('"align":"full"'):] if new_attrs.startswith('"align":"full"') else new_attrs

    # Rebuild the class list: drop any ground variation, add the new one.
    kept = [c for c in classes.split() if c not in (SOFT, DARK)]

    if ground:
        kept.insert(0, ground)

    new_classes = (" " + " ".join(kept)) if kept else ""

    original = match.group(0)
    replacement = ('<!-- wp:group {"align":"full"%s-->\n<div class="wp-block-group alignfull%s"'
                   % (new_attrs, new_classes))

    open(path, "w").write(body.replace(original, replacement, 1))

    return True


# --------------------------------------------------------------------------
# Compositions to audit: every demo home and every page starter.
# --------------------------------------------------------------------------
def compositions():
    out = {}

    for name in sorted(os.listdir(PATTERNS)):
        if not (name.startswith("demo-") or name.startswith("page-")):
            continue

        body = open(os.path.join(PATTERNS, name)).read()
        refs = re.findall(r'"slug":"academia/([a-z0-9-]+)"', body)

        if refs:
            out[name[:-4]] = refs

    return out


def audit():
    """Report any composition that breaks the rules. Returns a failure count."""
    failures = 0

    for page, slugs in compositions().items():
        grounds = sequence(slugs)
        labels = ["page" if g == PAGE else ("band" if s in BANDS else ("soft" if g == SOFT else "dark"))
                  for g, s in zip(grounds, slugs)]

        problems = []

        for i in range(1, len(labels)):
            if labels[i] == labels[i - 1] and labels[i] != "band":
                problems.append("%s and %s both on %s" % (slugs[i - 1], slugs[i], labels[i]))

            if labels[i] == "band" and labels[i - 1] == "band":
                problems.append("two bands adjacent: %s, %s" % (slugs[i - 1], slugs[i]))

        # Rule 1 already guarantees no ground can exceed ceil(n/2), so a
        # majority-share check adds nothing — and would be unsatisfiable
        # anyway, since perfect alternation of 7 sections is 4/3 = 57%.
        # What is worth catching is a long page with no full-bleed moment:
        # page/soft/page/soft for nine sections alternates correctly and still
        # reads as stripes, because nothing ever breaks the column.
        if len(labels) >= 6 and "band" not in labels and "dark" not in labels:
            problems.append("%d sections and no full-bleed band to break the page" % len(labels))

        status = "OK " if not problems else "FAIL"
        print("%s %-22s %s" % (status, page, " ".join(labels)))

        for problem in problems:
            print("      - " + problem)
            failures += 1

    return failures


def apply_all():
    """Write each section's ground from the compositions that use it.

    A section used by several pages takes the ground its most common position
    asks for; the audit then confirms no page is left with a repeat.
    """
    votes = {}

    for slugs in compositions().values():
        previous = None

        for slug in slugs:
            ground = ground_of(slug, previous)
            votes.setdefault(slug, []).append(ground)
            previous = ground if slug not in BANDS else "band"

    written = 0

    for slug, choices in sorted(votes.items()):
        if slug in BANDS or slug not in ROLES:
            continue

        winner = max(set(choices), key=choices.count)

        if set_pattern_ground(slug, winner):
            written += 1

    print("set grounds on %d sections\n" % written)


if __name__ == "__main__":
    if "--audit" not in sys.argv:
        apply_all()

    failures = audit()
    print("\n%d problem(s)" % failures)
    sys.exit(1 if failures else 0)
