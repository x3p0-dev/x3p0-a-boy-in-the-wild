---
name: wp-block-style-variations
description: >
  Creating and modifying block style variations (also called block styles)
  for WordPress block themes. Use this skill before creating any new block
  style file or modifying an existing one. Triggers on: "add a block style",
  "add a block style variation", "style this block differently", or any task
  that produces a file under styles/. Reference:
  https://developer.wordpress.org/themes/features/block-style-variations/
---

# WordPress Block Style Variations

Block style variations — also called block styles — are JSON files that
register alternative visual styles for specific blocks. Read this before
creating or modifying any block style variation file.

---

## Registration

Any JSON file under the theme's `styles/` folder is auto-registered by
WordPress. A file becomes a block style variation specifically when it
includes a `blockTypes` field. Without `blockTypes`, it registers as a
global style variation instead.

Good practice: place block-specific variations under `styles/block/`.

---

## File structure and naming

### Single block type

When a variation applies to one block type:

```
styles/block/{blockname}-{variation}.json
```

Slug: `{blockname}-{variation}`
WordPress class: `is-style-{blockname}-{variation}`

### Multiple block types of the same conceptual group

When a variation applies to multiple blocks of the same conceptual type
(e.g. Image and Post Featured Image), use a shared type prefix:

```
styles/block/{type}-{variation}.json
```

Slug: `{type}-{variation}`

### Subfolders

Once any block or type accumulates multiple variations (roughly 3 or more,
or whenever the folder gets crowded), move them into a subfolder:

```
styles/block/{blockname}/{variation}.json
styles/block/{type}/{variation}.json
```

The slug is not affected by the subfolder — it remains `{blockname}-{variation}`
or `{type}-{variation}`.

### Section styles

Section styles are block style variations applied to container-type blocks
(Group, Columns, etc.) to define color palettes for page sections. WordPress
convention uses a numbered naming system for reusability across themes:

```
styles/{section-1}.json
styles/{section-2}.json
```

- Slug: `section-1`, `section-2`, etc.
- Title: `Style 1`, `Style 2`, etc.
- `blockTypes`: `["core/group"]` (or other container blocks)

This convention allows patterns and templates to reference section styles
by number, making them portable across themes that follow the same naming.

**Examples:**

| File | Slug | Class |
|---|---|---|
| `styles/block/separator-dashed.json` | `separator-dashed` | `is-style-separator-dashed` |
| `styles/block/image-sketch.json` | `image-sketch` | `is-style-image-sketch` |
| `styles/block/image/sketch.json` | `image-sketch` | `is-style-image-sketch` |
| `styles/block/text-dateline.json` | `text-dateline` | `is-style-text-dateline` |
| `styles/section-1.json` | `section-1` | `is-style-section-1` |

---

## Required top-level fields

Every block style variation file must include all five:

```json
{
    "$schema": "https://schemas.wp.org/trunk/theme.json",
    "version": 3,
    "title": "Human-readable title",
    "slug": "{slug}",
    "blockTypes": ["core/{blockname}"]
}
```

- `$schema` — always `https://schemas.wp.org/trunk/theme.json`
- `version` — always `3`
- `title` — shown in the editor style picker. Clear and descriptive.
- `slug` — drives the `is-style-{slug}` class. Must match the naming
  convention for its location.
- `blockTypes` — array of block type strings. Required to register as a
  block style variation. May include multiple block types.

---

## Writing styles — structured properties first

**Always use the correct structured `styles` property if the schema supports
it.** Never use the `css` property as a shortcut for something the schema can
express natively. Before writing any CSS, check the schema at
`https://schemas.wp.org/trunk/theme.json` for the correct property.

Common structured properties and their correct paths:

| What you want | Correct property | Never use |
|---|---|---|
| Border radius | `styles.border.radius` | `css: "border-radius: ..."` |
| Box shadow | `styles.shadow` | `css: "box-shadow: ..."` |
| Padding | `styles.spacing.padding` | `css: "padding: ..."` |
| Margin | `styles.spacing.margin` | `css: "margin: ..."` |
| Font family | `styles.typography.fontFamily` | `css: "font-family: ..."` |
| Font size | `styles.typography.fontSize` | `css: "font-size: ..."` |
| Line height | `styles.typography.lineHeight` | `css: "line-height: ..."` |
| Text color | `styles.color.text` | `css: "color: ..."` |
| Background color | `styles.color.background` | `css: "background-color: ..."` |
| Caption styles | `styles.elements.caption` | `css: ".wp-element-caption { ... }"` |
| Link styles | `styles.elements.link` | `css: "a { ... }"` |
| Heading styles | `styles.elements.heading` | `css: "h1, h2 { ... }"` |
| Min height | `styles.dimensions.minHeight` | `css: "min-height: ..."` |
| Border width | `styles.border.width` | `css: "border-width: ..."` |

**Always use presets for values.** Any value that has a WordPress preset
should use the preset rather than a hardcoded value. This applies to color,
spacing, typography, border radius, shadow, and anything else with a
registered preset. Only use hardcoded values when no preset exists for what
you need.

```json
"fontFamily": "var(--wp--preset--font-family--body)",
"fontSize": "var(--wp--preset--font-size--small)",
"color": { "text": "var(--wp--preset--color--foreground)" },
"shadow": "var(--wp--preset--shadow--medium)",
"spacing": { "padding": { "top": "var(--wp--preset--spacing--40)" } }
```

**Property order in `styles`:**
- `css` first, if present
- All other properties alphabetically

---

## Spacing rules

Variations should generally not define spacing. Margin, padding, and
blockGap are almost always better handled at the pattern or block level, or
left to theme defaults. Adding spacing in a variation overrides those
defaults in ways that are difficult to predict and hard to undo.

**Margin** — avoid. Leave margin to the layout and editor.

**Padding** — only when the variation's visual effect structurally requires
something to pad against. If there is no structural reason for padding,
omit it.

**BlockGap** — only when the variation explicitly changes the spacing between
inner blocks as part of its design intent.

**Nested elements** — spacing rules on nested elements (captions, links,
headings via `styles.elements`) are exempt from the above. These are scoped
to the element and do not affect the outer block's spacing.

---

## When to use the `css` property

Use `css` only for things the schema cannot express:

- Pseudo-elements — `::before`, `::after`
- Pseudo-classes — `:hover`, `:focus`
- Nested element selectors — `> img`, `& + p`
- CSS functions not supported as structured values
- Setting CSS custom properties — `--my-token: value`

When writing `css`, target the block's root element with `&` only when
needed. For properties that apply to the block itself, write the value
directly:

```json
"css": "opacity: 0.5;"
```

Use `&` when the selector needs to be explicit:

```json
"css": "&::before { content: '—'; display: block; }"
```

**`css` in the JSON is for short additions only.** If the raw CSS exceeds
3 lines, move it to a block stylesheet instead — see below.

---

## Block stylesheets

When a variation's CSS exceeds 3 lines, move it to a dedicated block
stylesheet. See: https://developer.wordpress.org/themes/features/block-stylesheets/

The stylesheet uses the `is-style-{slug}` class as its root selector:

```css
.is-style-{slug} {
    /* variation styles */

    &:hover {
        /* hover state */
    }

    > img {
        /* child element styles */
    }
}
```

The JSON file still exists and handles everything the schema can express
structurally. The stylesheet handles the rest. The two work together — the
JSON is not replaced by the stylesheet.

---

## Examples

### Simple block variation — `styles/block/separator-dashed.json`

```json
{
    "$schema": "https://schemas.wp.org/trunk/theme.json",
    "version": 3,
    "title": "Dashed",
    "slug": "separator-dashed",
    "blockTypes": ["core/separator"],
    "styles": {
        "border": {
            "top": {
                "style": "dashed",
                "width": "1px"
            }
        },
        "color": {
            "background": "transparent"
        }
    }
}
```

### Image variation with companion stylesheet — `styles/block/image/sketch.json`

```json
{
    "$schema": "https://schemas.wp.org/trunk/theme.json",
    "version": 3,
    "title": "Sketch",
    "slug": "image-sketch",
    "blockTypes": ["core/image", "core/post-featured-image"],
    "styles": {
        "border": {
            "radius": "0"
        },
        "elements": {
            "caption": {
                "color": {
                    "text": "var(--wp--preset--color--foreground)"
                },
                "spacing": {
                    "margin": {
                        "bottom": "0",
                        "top": "var(--wp--preset--spacing--40)"
                    }
                },
                "typography": {
                    "fontSize": "var(--wp--preset--font-size--small)",
                    "textAlign": "center"
                }
            }
        },
        "shadow": "var(--wp--preset--shadow--medium)",
        "spacing": {
            "padding": {
                "bottom": "var(--wp--preset--spacing--40)",
                "left": "var(--wp--preset--spacing--40)",
                "right": "var(--wp--preset--spacing--40)",
                "top": "var(--wp--preset--spacing--40)"
            }
        }
    }
}
```

Companion stylesheet (exceeds 3 lines — lives in a block stylesheet):

```css
.is-style-image-sketch {
    background-color: var(--wp--preset--color--background);
    border-radius: 2px 3px 2px 3px / 3px 2px 3px 2px;
    transform: rotate(-1.8deg);
    transform-origin: center center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;

    &:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        transform: rotate(0deg) translateY(-2px);
    }

    > img {
        display: block;
        outline: 1px solid var(--wp--preset--color--border);
        width: 100%;
    }
}
```

---

## What not to do

- Do not use `styles.css` for anything the schema can express with a
  structured property.
- Do not hardcode color, spacing, typography, shadow, border radius, or
  other values that have a registered preset — always use presets.
- Do not leave more than 3 lines of raw CSS in the JSON `css` property —
  move it to a block stylesheet.
- Do not add margin — leave it to the layout and editor.
- Do not add padding unless the variation's visual effect structurally
  requires it.
- Do not omit any of the five required top-level fields.
- Do not omit `blockTypes` — without it the file registers as a global
  style variation, not a block style variation.
- Do not use a different `$schema` URL — it is always
  `https://schemas.wp.org/trunk/theme.json`.
- Do not place `css` anywhere other than first in the `styles` object.
- Do not order other properties other than alphabetically.
