#!/usr/bin/env python3
"""Generate theme.json and every styles/*.json variation for Academia.

One source of truth for the design system. Run from the theme root:

    python3 .dev/build_theme.py

Everything it writes is committed as-is; the theme has no build step at runtime.
"""

import json
import os
import collections

ROOT = os.path.dirname(os.path.dirname(os.path.abspath(__file__)))

SCHEMA = "https://schemas.wp.org/trunk/theme.json"

# --------------------------------------------------------------------------
# Fonts
# --------------------------------------------------------------------------
# Subsets, verbatim from the woff2 files generated for the font assets.
LATIN_EXT = (
    "U+0100-02BA, U+02BD-02C5, U+02C7-02CC, U+02CE-02D7, U+02DD-02FF, U+0304, "
    "U+0308, U+0329, U+1D00-1DBF, U+1E00-1E9F, U+1EF2-1EFF, U+2020, U+20A0-20AB, "
    "U+20AD-20C0, U+2113, U+2C60-2C7F, U+A720-A7FF"
)
LATIN = (
    "U+0000-00FF, U+0131, U+0152-0153, U+02BB-02BC, U+02C6, U+02DA, U+02DC, "
    "U+0304, U+0308, U+0329, U+2000-206F, U+20AC, U+2122, U+2191, U+2193, "
    "U+2212, U+2215, U+FEFF, U+FFFD"
)

SANS = "ui-sans-serif, system-ui, -apple-system, sans-serif"

# name -> (directory, stack, [(weight, file-stem), ...])
FONTS = {
    "Manrope": ("manrope", "Manrope, " + SANS, [("200 800", "manrope-normal")]),
    "Inter": ("inter", "Inter, " + SANS, [("100 900", "inter-normal")]),
    "Fraunces": ("fraunces", "Fraunces, ui-serif, Georgia, serif", [("300 900", "fraunces-normal")]),
    "Space Grotesk": ("space-grotesk", '"Space Grotesk", ' + SANS, [("300 700", "space-grotesk-normal")]),
    "Nunito": ("nunito", "Nunito, " + SANS, [("300 800", "nunito-300-800")]),
    "Poppins": ("poppins", "Poppins, " + SANS, [(str(w), "poppins-%d" % w) for w in (400, 500, 600, 700)]),
}

SYSTEM_FAMILY = {
    "slug": "system",
    "name": "System",
    "fontFamily": 'ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif',
}


def family(slug, name):
    """A font family entry carrying one @font-face per weight per subset."""
    directory, stack, weights = FONTS[name]
    faces = []
    for weight, stem in weights:
        for subset, urange in (("-ext", LATIN_EXT), ("", LATIN)):
            faces.append(collections.OrderedDict([
                ("fontFamily", name),
                ("fontStyle", "normal"),
                ("fontWeight", weight),
                ("fontDisplay", "swap"),
                ("unicodeRange", urange),
                ("src", ["file:./assets/fonts/%s/%s-latin%s.woff2" % (directory, stem, subset)]),
            ]))
    return collections.OrderedDict([
        ("slug", slug), ("name", name), ("fontFamily", stack), ("fontFace", faces),
    ])


# --------------------------------------------------------------------------
# Colour
# --------------------------------------------------------------------------
# Academia's identity is the teal the HTML template shipped, #1eb2a6. That value
# is 2.63:1 on white — it fails WCAG AA as text and as a button ground, so the
# palette keeps the hue and darkens it: `primary` #0f766e is 5.47:1 both ways.
# #1eb2a6 survives as `teal-light`, for large decorative fills only.
PALETTE = [
    ("Base", "base", "#ffffff"),
    ("Surface", "surface", "#f4f8f7"),
    ("Contrast", "contrast", "#0f1a1e"),
    ("Muted", "muted", "#4b5563"),
    ("Primary", "primary", "#0f766e"),
    ("Primary deep", "primary-deep", "#115e59"),
    ("Teal light", "teal-light", "#1eb2a6"),
    ("Accent", "accent", "#b45309"),
    ("Dark", "dark", "#0b1720"),
    ("Divider", "divider", "#c3d3cf"),
]

# Colour-only variations. Each keeps the same ten slugs so every pattern follows.
# primary/primary-deep are always AA on base, and base is always AA on primary.
COLOR_SETS = {
    "colors-1-teal": ("Teal", {
        "base": "#ffffff", "surface": "#f4f8f7", "contrast": "#0f1a1e", "muted": "#4b5563",
        "primary": "#0f766e", "primary-deep": "#115e59", "teal-light": "#1eb2a6",
        "accent": "#b45309", "dark": "#0b1720", "divider": "#c3d3cf",
    }),
    "colors-2-indigo": ("Indigo", {
        "base": "#ffffff", "surface": "#f5f6fb", "contrast": "#12142b", "muted": "#4c5270",
        "primary": "#4338ca", "primary-deep": "#312e81", "teal-light": "#6366f1",
        "accent": "#b45309", "dark": "#111233", "divider": "#ccd0e6",
    }),
    "colors-3-forest": ("Forest", {
        "base": "#ffffff", "surface": "#f4f8f3", "contrast": "#11210f", "muted": "#4a5a48",
        "primary": "#15803d", "primary-deep": "#14532d", "teal-light": "#22c55e",
        "accent": "#a16207", "dark": "#0d1a0c", "divider": "#c6d6c2",
    }),
    "colors-4-slate": ("Slate", {
        "base": "#ffffff", "surface": "#f6f7f9", "contrast": "#111827", "muted": "#4b5563",
        "primary": "#334155", "primary-deep": "#1e293b", "teal-light": "#64748b",
        "accent": "#b45309", "dark": "#0f172a", "divider": "#ccd3dd",
    }),
    "colors-5-plum": ("Plum", {
        "base": "#ffffff", "surface": "#faf5f9", "contrast": "#22102a", "muted": "#5c4a63",
        "primary": "#9333ea", "primary-deep": "#6b21a8", "teal-light": "#c084fc",
        "accent": "#0f766e", "dark": "#1b0f22", "divider": "#e0cde0",
    }),
    "colors-6-ember": ("Ember", {
        "base": "#ffffff", "surface": "#fdf6f3", "contrast": "#26130c", "muted": "#5f4b42",
        "primary": "#c2410c", "primary-deep": "#9a3412", "teal-light": "#fb923c",
        "accent": "#0f766e", "dark": "#1e1009", "divider": "#e8d2c6",
    }),
    "colors-7-midnight": ("Midnight", {
        "base": "#0e1526", "surface": "#16203a", "contrast": "#f3f6fc", "muted": "#a9b6d0",
        "primary": "#7dd3fc", "primary-deep": "#38bdf8", "teal-light": "#0ea5e9",
        "accent": "#fbbf24", "dark": "#080d19", "divider": "#33415f",
    }),
    "colors-8-slate-dark": ("Graphite", {
        "base": "#141414", "surface": "#1e1e1e", "contrast": "#f5f5f4", "muted": "#b3b1ac",
        "primary": "#5eead4", "primary-deep": "#2dd4bf", "teal-light": "#14b8a6",
        "accent": "#fbbf24", "dark": "#0a0a0a", "divider": "#3d3d3d",
    }),
}

# Palettes whose `base` is dark. Buttons there need light text, and the dark
# section style has to put base/contrast back to their light-mode meaning.
DARK_PALETTES = {"colors-7-midnight", "colors-8-slate-dark"}

TYPE_SETS = {
    "typography-1-academy": ("Manrope & Inter", "Manrope", "Inter", "700", "-0.02em"),
    "typography-2-editorial": ("Fraunces & Inter", "Fraunces", "Inter", "600", "-0.015em"),
    "typography-3-friendly": ("Poppins & Nunito", "Poppins", "Nunito", "600", "-0.01em"),
    "typography-4-technical": ("Space Grotesk & Inter", "Space Grotesk", "Inter", "600", "-0.015em"),
    "typography-5-neutral": ("Inter", "Inter", "Inter", "650", "-0.02em"),
}

# Curated full looks: a palette paired with a typeface. Starter sites use these.
LOOKS = {
    "academy": ("Academy", "colors-1-teal", "typography-1-academy"),
    "university": ("University", "colors-2-indigo", "typography-2-editorial"),
    "kindergarten": ("Kindergarten", "colors-6-ember", "typography-3-friendly"),
    "bootcamp": ("Bootcamp", "colors-4-slate", "typography-4-technical"),
    "campus": ("Campus", "colors-3-forest", "typography-1-academy"),
    "studio": ("Studio", "colors-5-plum", "typography-5-neutral"),
    "night": ("Night", "colors-7-midnight", "typography-4-technical"),
    "graphite": ("Graphite", "colors-8-slate-dark", "typography-5-neutral"),
}


def write(path, data):
    full = os.path.join(ROOT, path)
    os.makedirs(os.path.dirname(full), exist_ok=True)
    with open(full, "w") as handle:
        json.dump(data, handle, indent="\t", ensure_ascii=False)
        handle.write("\n")
    return path


# --------------------------------------------------------------------------
# theme.json
# --------------------------------------------------------------------------
def build_theme():
    settings = collections.OrderedDict([
        ("appearanceTools", True),
        ("useRootPaddingAwareAlignments", True),
        ("layout", {"contentSize": "780px", "wideSize": "1240px"}),
        ("lightbox", {"enabled": True, "allowEditing": True}),
        ("color", collections.OrderedDict([
            ("defaultPalette", False), ("defaultGradients", False), ("defaultDuotone", False),
            ("palette", [{"name": n, "slug": s, "color": c} for n, s, c in PALETTE]),
            ("gradients", [
                {"name": "Primary to deep", "slug": "primary-to-deep",
                 "gradient": "linear-gradient(135deg, #0f766e 0%, #115e59 100%)"},
                {"name": "Primary to teal", "slug": "primary-to-teal",
                 "gradient": "linear-gradient(135deg, #0f766e 0%, #1eb2a6 100%)"},
                {"name": "Dark to primary", "slug": "dark-to-primary",
                 "gradient": "linear-gradient(135deg, #0b1720 0%, #115e59 100%)"},
                {"name": "Surface fade", "slug": "surface-fade",
                 "gradient": "linear-gradient(180deg, #f4f8f7 0%, rgba(244,248,247,0) 100%)"},
            ]),
        ])),
        # Shadows are built with color-mix() on a palette colour so they follow
        # whichever palette is active. They live here, not in a colour partial:
        # a stray settings.shadow demotes a colour variation to a full one.
        ("shadow", {"defaultPresets": False, "presets": [
            {"name": "Card", "slug": "card",
             "shadow": "0 1px 1px color-mix(in srgb, var(--wp--preset--color--contrast) 4%, transparent), "
                       "0 2px 6px color-mix(in srgb, var(--wp--preset--color--contrast) 6%, transparent), "
                       "0 10px 20px -8px color-mix(in srgb, var(--wp--preset--color--contrast) 10%, transparent)"},
            {"name": "Lifted", "slug": "lifted",
             "shadow": "0 2px 4px color-mix(in srgb, var(--wp--preset--color--contrast) 6%, transparent), "
                       "0 8px 16px -4px color-mix(in srgb, var(--wp--preset--color--contrast) 10%, transparent), "
                       "0 24px 48px -12px color-mix(in srgb, var(--wp--preset--color--contrast) 18%, transparent)"},
            {"name": "Ring", "slug": "ring",
             "shadow": "0 0 0 1px color-mix(in srgb, var(--wp--preset--color--contrast) 10%, transparent)"},
        ]}),
        ("spacing", {
            "defaultSpacingSizes": False,
            "units": ["px", "em", "rem", "%", "vw", "vh"],
            # Slugs 20-80 in tens, sizes fluid from 50 up so a section that is
            # 96px tall on a desktop is 48px on a phone without a media query.
            # sp() in pgen.py refuses anything off this scale: an unregistered
            # slug resolves to an undefined custom property and WP drops the
            # declaration silently, leaving the element on its inherited gap.
            "spacingSizes": [
                {"name": "1", "slug": "20", "size": "0.5rem"},
                {"name": "2", "slug": "30", "size": "1rem"},
                {"name": "3", "slug": "40", "size": "1.5rem"},
                {"name": "4", "slug": "50", "size": "clamp(1.5rem, 4vw, 2.5rem)"},
                {"name": "5", "slug": "60", "size": "clamp(2rem, 6vw, 4rem)"},
                {"name": "6", "slug": "70", "size": "clamp(3rem, 8vw, 6rem)"},
                {"name": "7", "slug": "80", "size": "clamp(4rem, 10vw, 8rem)"},
            ],
        }),
        ("typography", collections.OrderedDict([
            ("fluid", True), ("defaultFontSizes", False),
            ("fontFamilies", [family("heading", "Manrope"), family("body", "Inter"), SYSTEM_FAMILY]),
            ("fontSizes", [
                {"name": "Small", "slug": "small", "size": "0.875rem", "fluid": False},
                {"name": "Medium", "slug": "medium", "size": "1.0625rem",
                 "fluid": {"min": "1rem", "max": "1.0625rem"}},
                {"name": "Large", "slug": "large", "size": "1.375rem",
                 "fluid": {"min": "1.1875rem", "max": "1.375rem"}},
                {"name": "X Large", "slug": "x-large", "size": "2rem",
                 "fluid": {"min": "1.625rem", "max": "2rem"}},
                {"name": "Huge", "slug": "huge", "size": "2.75rem",
                 "fluid": {"min": "2rem", "max": "2.75rem"}},
                {"name": "Display", "slug": "display", "size": "4rem",
                 "fluid": {"min": "2.5rem", "max": "4rem"}},
            ]),
        ])),
        ("blocks", {
            "core/button": {"border": {"radius": True}},
            "core/pullquote": {"border": {"color": True, "radius": True, "style": True, "width": True}},
        }),
        ("position", {"sticky": True}),
        ("background", {"backgroundImage": True, "backgroundSize": True}),
        ("dimensions", {"aspectRatio": True, "minHeight": True}),
        ("viewport", {"mobile": "600px", "tablet": "782px"}),
    ])

    styles = collections.OrderedDict([
        ("color", {"background": "var:preset|color|base", "text": "var:preset|color|contrast"}),
        ("typography", {
            "fontFamily": "var:preset|font-family|body",
            "fontSize": "var:preset|font-size|medium",
            "fontWeight": "400",
            "lineHeight": "1.7",
        }),
        ("spacing", {
            "blockGap": "1.25rem",
            # Root padding: left/right only. alignfull constrained groups inherit
            # it via useRootPaddingAwareAlignments, so section patterns set only
            # top/bottom padding or they double-pad. Needs units — a unitless "0"
            # invalidates the navigation overlay's clamp() and the mobile menu
            # loses all its padding.
            "padding": {"top": "0px", "bottom": "0px",
                        "left": "var:preset|spacing|40", "right": "var:preset|spacing|40"},
        }),
        ("elements", collections.OrderedDict([
            ("link", {
                "color": {"text": "var:preset|color|primary"},
                "typography": {"textDecoration": "underline"},
                ":hover": {"typography": {"textDecoration": "none"}},
                ":focus": {"outline": {"color": "var:preset|color|primary", "style": "solid", "width": "2px", "offset": "2px"}},
            }),
            ("heading", {
                "color": {"text": "var:preset|color|contrast"},
                "typography": {
                    "fontFamily": "var:preset|font-family|heading",
                    "fontWeight": "700",
                    "lineHeight": "1.2",
                    "letterSpacing": "-0.02em",
                },
            }),
            ("h1", {"typography": {"fontSize": "var:preset|font-size|display", "lineHeight": "1.06"}}),
            ("h2", {"typography": {"fontSize": "var:preset|font-size|huge", "lineHeight": "1.14"}}),
            ("h3", {"typography": {"fontSize": "var:preset|font-size|x-large"}}),
            ("h4", {"typography": {"fontSize": "var:preset|font-size|large"}}),
            ("h5", {"typography": {"fontSize": "var:preset|font-size|medium"}}),
            ("h6", {"typography": {
                "fontSize": "var:preset|font-size|small", "letterSpacing": "0.08em",
                "textTransform": "uppercase", "fontWeight": "700",
            }}),
            # White on #0f766e is 5.47:1. Radius is 12px, not a pill: the squarer
            # button is what separates Academia from Unapp at a glance.
            ("button", collections.OrderedDict([
                ("color", {"background": "var:preset|color|primary", "text": "var:preset|color|base"}),
                ("border", {"radius": "12px", "width": "0px"}),
                ("typography", {
                    "fontFamily": "var:preset|font-family|heading",
                    "fontSize": "var:preset|font-size|small",
                    "fontWeight": "600",
                    "letterSpacing": "0.01em",
                }),
                ("spacing", {"padding": {"top": "0.9rem", "bottom": "0.9rem", "left": "1.6rem", "right": "1.6rem"}}),
                (":hover", {"color": {"background": "var:preset|color|primary-deep", "text": "var:preset|color|base"}}),
                (":focus", {"color": {"background": "var:preset|color|primary-deep", "text": "var:preset|color|base"},
                            "outline": {"color": "var:preset|color|contrast", "style": "solid", "width": "2px", "offset": "2px"}}),
                (":active", {"color": {"background": "var:preset|color|primary-deep", "text": "var:preset|color|base"}}),
            ])),
            ("caption", {"color": {"text": "var:preset|color|muted"},
                         "typography": {"fontSize": "var:preset|font-size|small"}}),
        ])),
        ("blocks", collections.OrderedDict([
            ("core/site-title", {
                "typography": {"fontFamily": "var:preset|font-family|heading", "fontSize": "var:preset|font-size|large",
                               "fontWeight": "800", "letterSpacing": "-0.03em", "textTransform": "uppercase"},
                "elements": {"link": {"typography": {"textDecoration": "none"},
                                      ":hover": {"typography": {"textDecoration": "none"}}}},
            }),
            ("core/site-tagline", {
                "typography": {"fontSize": "var:preset|font-size|small"},
                "color": {"text": "var:preset|color|muted"},
            }),
            ("core/navigation", {
                "typography": {"fontFamily": "var:preset|font-family|heading",
                               "fontSize": "var:preset|font-size|small", "fontWeight": "500"},
                "elements": {"link": {"typography": {"textDecoration": "none"},
                                      ":hover": {"color": {"text": "var:preset|color|primary"},
                                                 "typography": {"textDecoration": "none"}}}},
            }),
            ("core/post-title", {
                "typography": {"fontWeight": "700"},
                "elements": {"link": {"typography": {"textDecoration": "none"},
                                      ":hover": {"typography": {"textDecoration": "underline"}}}},
            }),
            ("core/post-date", {"typography": {"fontSize": "var:preset|font-size|small"},
                                "color": {"text": "var:preset|color|muted"},
                                "elements": {"link": {"typography": {"textDecoration": "none"}}}}),
            ("core/post-author-name", {"typography": {"fontSize": "var:preset|font-size|small"},
                                       "color": {"text": "var:preset|color|muted"},
                                       "elements": {"link": {"typography": {"textDecoration": "none"}}}}),
            ("core/post-terms", {
                "typography": {"fontSize": "var:preset|font-size|small", "fontWeight": "600"},
                "color": {"text": "var:preset|color|primary"},
                "elements": {"link": {"typography": {"textDecoration": "none"},
                                      ":hover": {"typography": {"textDecoration": "underline"}}}},
            }),
            ("core/post-excerpt", {"color": {"text": "var:preset|color|muted"}}),
            ("core/read-more", {"typography": {"fontFamily": "var:preset|font-family|heading",
                                               "fontSize": "var:preset|font-size|small", "fontWeight": "600",
                                               "textDecoration": "none"}}),
            ("core/query-pagination", {"typography": {"fontFamily": "var:preset|font-family|heading",
                                                      "fontSize": "var:preset|font-size|small"},
                                       "elements": {"link": {"typography": {"textDecoration": "none"}}}}),
            ("core/post-navigation-link", {"typography": {"fontFamily": "var:preset|font-family|heading",
                                                          "fontWeight": "600"},
                                           "elements": {"link": {"typography": {"textDecoration": "none"}}}}),
            ("core/quote", {
                "border": {"left": {"color": "var:preset|color|primary", "style": "solid", "width": "3px"}},
                "spacing": {"padding": {"left": "var:preset|spacing|30"}},
                "typography": {"fontSize": "var:preset|font-size|large", "lineHeight": "1.5"},
            }),
            ("core/pullquote", {
                "border": {"color": "var:preset|color|divider", "radius": "20px", "style": "solid", "width": "1px"},
                "spacing": {"padding": {"top": "var:preset|spacing|50", "bottom": "var:preset|spacing|50",
                                        "left": "var:preset|spacing|50", "right": "var:preset|spacing|50"}},
                "typography": {"fontSize": "var:preset|font-size|x-large", "fontWeight": "600", "lineHeight": "1.3"},
            }),
            ("core/code", {
                "color": {"background": "var:preset|color|surface", "text": "var:preset|color|contrast"},
                "border": {"color": "var:preset|color|divider", "radius": "14px", "style": "solid", "width": "1px"},
                "spacing": {"padding": {"top": "var:preset|spacing|30", "bottom": "var:preset|spacing|30",
                                        "left": "var:preset|spacing|30", "right": "var:preset|spacing|30"}},
                "typography": {"fontSize": "var:preset|font-size|small", "lineHeight": "1.6"},
            }),
            ("core/separator", {"color": {"text": "var:preset|color|divider"}}),
            ("core/table", {"typography": {"fontSize": "var:preset|font-size|small"},
                            "css": "& td{border-color:var(--wp--preset--color--divider)}"
                                   "& th{border-color:var(--wp--preset--color--divider)}"}),
            ("core/image", {"css": "& img{border-radius:20px}"
                                   "&.is-style-rounded img{border-radius:999px}"}),
            ("core/avatar", {"border": {"radius": "999px"}}),
            ("core/search", {
                "typography": {"fontSize": "var:preset|font-size|small"},
                "css": "& .wp-block-search__input{border-radius:12px;border:1px solid var(--wp--preset--color--divider);"
                       "padding:0.8rem 1rem;background:var(--wp--preset--color--base);color:var(--wp--preset--color--contrast)}",
            }),
            ("core/cover", {"spacing": {"padding": {"top": "var:preset|spacing|80", "bottom": "var:preset|spacing|80"}}}),
            ("core/heading", {"@mobile": {"typography": {"letterSpacing": "-0.01em"}}}),
        ])),
    ])

    theme = collections.OrderedDict([
        ("$schema", SCHEMA), ("version", 3), ("settings", settings), ("styles", styles),
    ])
    return write("theme.json", theme)


# --------------------------------------------------------------------------
# Style variations
# --------------------------------------------------------------------------
def build_colors():
    """Colour-only partials. Nothing but settings.color + styles colour keys,
    or the Site Editor demotes them out of the Colors group."""
    written = []
    for slug, (title, colors) in COLOR_SETS.items():
        is_dark = slug in DARK_PALETTES
        data = collections.OrderedDict([
            ("$schema", SCHEMA), ("version", 3), ("title", title), ("slug", slug),
            ("settings", {"color": {"palette": [
                {"name": name, "slug": key, "color": colors[key]}
                for name, key, _ in PALETTE
            ]}}),
            ("styles", {
                "color": {"background": "var:preset|color|base", "text": "var:preset|color|contrast"},
                "elements": {
                    # In a dark palette `contrast` is light, so a button whose
                    # text is `base` would be light-on-light. Flip it.
                    "button": {"color": {
                        "background": "var:preset|color|primary",
                        "text": "var:preset|color|contrast" if is_dark else "var:preset|color|base",
                    }},
                    "heading": {"color": {"text": "var:preset|color|contrast"}},
                    "link": {"color": {"text": "var:preset|color|primary"}},
                },
            }),
        ])
        written.append(write("styles/colors/%s.json" % slug, data))
    return written


def build_typography():
    """Typography-only partials: each redefines the heading/body slugs so every
    pattern follows without touching a single pattern file."""
    written = []
    for slug, (title, head, body, weight, tracking) in TYPE_SETS.items():
        data = collections.OrderedDict([
            ("$schema", SCHEMA), ("version", 3), ("title", title), ("slug", slug),
            ("settings", {"typography": {"fontFamilies": [
                family("heading", head), family("body", body), SYSTEM_FAMILY,
            ]}}),
            ("styles", {
                "typography": {"fontFamily": "var:preset|font-family|body",
                               "fontWeight": "400", "lineHeight": "1.7"},
                "elements": {
                    "heading": {"typography": {"fontFamily": "var:preset|font-family|heading",
                                               "fontWeight": weight, "letterSpacing": tracking}},
                    "button": {"typography": {"fontFamily": "var:preset|font-family|heading"}},
                },
                "blocks": {
                    "core/site-title": {"typography": {"fontFamily": "var:preset|font-family|heading"}},
                    "core/navigation": {"typography": {"fontFamily": "var:preset|font-family|heading"}},
                    "core/post-title": {"typography": {"fontFamily": "var:preset|font-family|heading"}},
                },
            }),
        ])
        written.append(write("styles/typography/%s.json" % slug, data))
    return written


def build_looks():
    """Curated full looks — a palette paired with a typeface. Starter sites
    reference these by slug."""
    written = []
    for slug, (title, color_slug, type_slug) in LOOKS.items():
        _, colors = COLOR_SETS[color_slug]
        _, head, body, weight, tracking = TYPE_SETS[type_slug]
        is_dark = color_slug in DARK_PALETTES
        data = collections.OrderedDict([
            ("$schema", SCHEMA), ("version", 3), ("title", title), ("slug", slug),
            ("settings", {
                "color": {"palette": [{"name": n, "slug": k, "color": colors[k]} for n, k, _ in PALETTE]},
                "typography": {"fontFamilies": [family("heading", head), family("body", body), SYSTEM_FAMILY]},
            }),
            ("styles", {
                "color": {"background": "var:preset|color|base", "text": "var:preset|color|contrast"},
                "typography": {"fontFamily": "var:preset|font-family|body",
                               "fontWeight": "400", "lineHeight": "1.7"},
                "elements": {
                    "heading": {"color": {"text": "var:preset|color|contrast"},
                                "typography": {"fontFamily": "var:preset|font-family|heading",
                                               "fontWeight": weight, "letterSpacing": tracking}},
                    "link": {"color": {"text": "var:preset|color|primary"}},
                    "button": {"color": {"background": "var:preset|color|primary",
                                         "text": "var:preset|color|contrast" if is_dark else "var:preset|color|base"},
                               "typography": {"fontFamily": "var:preset|font-family|heading"}},
                },
            }),
        ])
        written.append(write("styles/%s.json" % slug, data))
    return written


def build_sections():
    """Section styles. Each needs blockTypes or it never reaches the block
    inspector's Styles panel."""
    written = []

    def section(slug, title, block_types, styles):
        data = collections.OrderedDict([
            ("$schema", SCHEMA), ("version", 3), ("title", title), ("slug", slug),
            ("blockTypes", block_types), ("styles", styles),
        ])
        written.append(write("styles/%s.json" % slug, data))

    group_col = ["core/group", "core/column"]
    section_types = ["core/group", "core/columns", "core/column"]

    section("card", "Card", group_col, {
        "color": {"background": "var:preset|color|base", "text": "var:preset|color|contrast"},
        "border": {"color": "var:preset|color|divider", "radius": "20px", "style": "solid", "width": "1px"},
        "shadow": "var:preset|shadow|card",
        "spacing": {"padding": {"top": "var:preset|spacing|40", "right": "var:preset|spacing|40",
                                "bottom": "var:preset|spacing|40", "left": "var:preset|spacing|40"}},
    })

    section("card-flat", "Card (flat)", group_col, {
        "color": {"background": "var:preset|color|surface", "text": "var:preset|color|contrast"},
        "border": {"radius": "20px", "width": "0px"},
        "spacing": {"padding": {"top": "var:preset|spacing|40", "right": "var:preset|spacing|40",
                                "bottom": "var:preset|spacing|40", "left": "var:preset|spacing|40"}},
    })

    section("section-soft", "Soft background", section_types, {
        "color": {"background": "var:preset|color|surface", "text": "var:preset|color|contrast"},
    })

    # On a dark ground `muted` and `border` would be near-invisible, so they are
    # redefined here. One `&` rule per selector: WP splits nested css on `&`.
    dark_css = ("& { --wp--preset--color--muted: rgba(255,255,255,0.74);"
                " --wp--preset--color--divider: rgba(255,255,255,0.16); }")

    section("section-dark", "Dark", section_types + ["core/cover"], {
        "color": {"background": "var:preset|color|dark", "text": "var:preset|color|base"},
        "css": dark_css,
        "elements": {
            "heading": {"color": {"text": "var:preset|color|base"}},
            "link": {"color": {"text": "var:preset|color|base"},
                     ":hover": {"color": {"text": "var:preset|color|teal-light"}}},
            "button": {"color": {"background": "var:preset|color|base", "text": "var:preset|color|contrast"},
                       ":hover": {"color": {"background": "var:preset|color|teal-light",
                                            "text": "var:preset|color|contrast"}}},
        },
    })

    section("section-gradient", "Gradient", section_types + ["core/cover"], {
        "color": {"gradient": "var:preset|gradient|primary-to-deep", "text": "var:preset|color|base"},
        "css": dark_css,
        "elements": {
            "heading": {"color": {"text": "var:preset|color|base"}},
            "link": {"color": {"text": "var:preset|color|base"}},
            "button": {"color": {"background": "var:preset|color|base", "text": "var:preset|color|primary"},
                       ":hover": {"color": {"background": "var:preset|color|contrast",
                                            "text": "var:preset|color|base"}}},
        },
    })

    section("elevated", "Elevated", group_col, {
        "color": {"background": "var:preset|color|base", "text": "var:preset|color|contrast"},
        "border": {"radius": "20px", "width": "0px"},
        "shadow": "var:preset|shadow|lifted",
        "spacing": {"padding": {"top": "var:preset|spacing|40", "right": "var:preset|spacing|40",
                                "bottom": "var:preset|spacing|40", "left": "var:preset|spacing|40"}},
    })

    section("outline", "Outline", group_col, {
        "border": {"color": "var:preset|color|primary", "radius": "20px", "style": "solid", "width": "2px"},
        "spacing": {"padding": {"top": "var:preset|spacing|40", "right": "var:preset|spacing|40",
                                "bottom": "var:preset|spacing|40", "left": "var:preset|spacing|40"}},
    })

    section("highlight", "Highlight", group_col, {
        "color": {"background": "var:preset|color|primary", "text": "var:preset|color|base"},
        "border": {"radius": "20px", "width": "0px"},
        "css": dark_css,
        "shadow": "var:preset|shadow|card",
        "spacing": {"padding": {"top": "var:preset|spacing|40", "right": "var:preset|spacing|40",
                                "bottom": "var:preset|spacing|40", "left": "var:preset|spacing|40"}},
        "elements": {
            "heading": {"color": {"text": "var:preset|color|base"}},
            "link": {"color": {"text": "var:preset|color|base"}},
            "button": {"color": {"background": "var:preset|color|base", "text": "var:preset|color|primary"}},
        },
    })

    return written


if __name__ == "__main__":
    out = [build_theme()]
    out += build_colors() + build_typography() + build_looks() + build_sections()
    print("wrote %d files:" % len(out))
    for path in out:
        print("  " + path)
