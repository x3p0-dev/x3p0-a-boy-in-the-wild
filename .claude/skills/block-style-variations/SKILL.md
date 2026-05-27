---
name: block-style-variations
description: >
  Creating and modifying block style variations and section styles for the
  A Boy in the Wild theme. Use this skill before creating any new style
  variation file, modifying an existing one, or choosing where a variation
  file should live. Triggers on: "add a block style variation", "create a
  section style", "add a new variation for X block", "style this block
  differently", or any task that produces a file under styles/block/ or
  styles/section/.
---

# Block Style Variations

Read this before creating or modifying any file under `styles/block/` or
`styles/section/`. The file structure, naming, slug, and JSON structure all
follow strict conventions.

---

## Two types, two folders

**`styles/block/`** — block style variations. Scoped to one or more specific
blocks. Applied as a style choice in the editor for that block.

**`styles/section/`** — section styles. Applied to container-type blocks
(Group, Columns, etc.). Two subtypes live here — chapter variations and
container variations — distinguished by naming convention.

---

## `styles/block/` — file structure and naming

The general pattern:

```
styles/block/{blockname}-{variation}.json
```

Slug: `{blockname}-{variation}`
WordPress class: `is-style-{blockname}-{variation}`

**Exceptions — blocks with their own subfolder:**

| Folder | Block types | Slug pattern |
|---|---|---|
| `styles/block/text/` | Paragraph, Heading, and other text blocks where only typography changes | `text-{variation}` |
| `styles/block/list/` | List, List Item | `list-{variation}` |
| `styles/block/image/` | Image, Post Featured Image, and other image-type blocks | `image-{variation}` |

Sub-folders are used for any block type with multiple variations, and for
block types where the same variation may apply across more than one block.

**Examples:**

| File | Slug | Class |
|---|---|---|
| `styles/block/separator-inline.json` | `separator-inline` | `is-style-separator-inline` |
| `styles/block/text/dateline.json` | `text-dateline` | `is-style-text-dateline` |
| `styles/block/image/sketch.json` | `image-sketch` | `is-style-image-sketch` |

---

## `styles/section/` — file structure and naming

Two subtypes, both at the top level of `styles/section/`:

**Chapter variations** — control the full colour world of a chapter. Applied
to the Entry Group block.

```
styles/section/{type}-{variation}.json
```

Slug: `section-{type}-{variation}`
Class: `is-style-section-{type}-{variation}`

Examples: `season-late-summer.json` → `section-season-late-summer`,
`arc-spine.json` → `section-arc-spine`

**Container variations** — structural styles for container blocks. The tilde
prefix sorts them separately in the file system.

```
styles/section/~{type}.json
```

Slug: `container-{type}`
Class: `is-style-container-{type}`

Example: `~prose.json` → `container-prose`

---

## Required top-level fields

Every variation file must include all five:

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
  convention for its folder.
- `blockTypes` — array of block type strings. Usually `["core/{blockname}"]`.
  May include multiple block types if the variation applies to more than one.

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
| Text colour | `styles.color.text` | `css: "color: ..."` |
| Background colour | `styles.color.background` | `css: "background-color: ..."` |
| Caption styles | `styles.elements.caption` | `css: ".wp-element-caption { ... }"` |
| Link styles | `styles.elements.link` | `css: "a { ... }"` |
| Heading styles | `styles.elements.heading` | `css: "h1, h2 { ... }"` |
| Min height | `styles.dimensions.minHeight` | `css: "min-height: ..."` |
| Border width | `styles.border.width` | `css: "border-width: ..."` |

Always use theme preset tokens for values rather than hardcoded values:

```json
"fontFamily": "var(--wp--preset--font-family--tertiary)",
"fontSize": "var(--wp--preset--font-size--sm)",
"lineHeight": "var(--wp--custom--line-height--sm)",
"color": { "text": "var(--wp--preset--color--ink-subtle)" },
"spacing": { "padding": { "top": "var(--wp--preset--spacing--40)" } }
```

---

## Spacing rules

Most variations should not define spacing. Margin, padding, and blockGap are
almost always handled at the pattern or block level, or fall back to theme
defaults. Adding spacing in a variation overrides those defaults in ways that
are difficult to predict and hard to undo.

**Margin** — nearly always forbidden in a variation. Do not set margin on the
outer block. Let the pattern or block level control it.

**Padding** — only warranted when the variation's visual effect requires
something to pad against. The `image-sketch` variation is the model case: the
paper background needs padding to show around the image. If there is no
structural reason for padding, omit it.

**BlockGap** — omit unless the variation explicitly changes the spacing
between inner blocks as part of its design intent.

**Nested elements** — spacing rules on nested elements (captions, links,
headings via `styles.elements`) are exempt from the above. These are scoped
to the element and do not affect the outer block's spacing. Apply them when
the variation's typography or layout requires it.

**Section and container variations** — spacing rules are especially
discouraged here. These variations control colour worlds and typography
registers, not layout geometry.

---

## When to use the `css` property

Use `css` only for things the schema cannot express:

- Pseudo-elements — `::before`, `::after`
- Pseudo-classes — `:hover`, `:focus`
- Nested element selectors — `> img`, `& + p`
- CSS functions not supported as structured values
- Setting CSS custom properties — `--my-token: value`

The `&` selector in `css` targets the block's root element.

**`css` in the JSON is for short additions only.** If the raw CSS for a
variation exceeds 3 lines, move it to a block stylesheet instead — see below.

**Exception:** CSS custom property overrides in section styles
(`styles/section/`) always stay in the JSON regardless of length. This is
the only supported way to override palette tokens per-variation.

---

## Block stylesheets

When a variation's CSS exceeds 3 lines, move it to a dedicated stylesheet.

**File location:**
```
resources/scss/block/{namespace}/{blockname}.scss
```

Compiled output: `public/css/block/{namespace}/{blockname}.css`

For core blocks: `resources/scss/block/core/paragraph.scss`,
`resources/scss/block/core/image.scss`, etc.

The stylesheet uses the `is-style-{slug}` class as its root selector:

```css
.is-style-image-sketch {
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

### Simple block variation — `styles/block/separator-inline.json`

```json
{
    "$schema": "https://schemas.wp.org/trunk/theme.json",
    "version": 3,
    "title": "Inline",
    "slug": "separator-inline",
    "blockTypes": ["core/separator"],
    "styles": {
        "color": {
            "background": "transparent",
            "text": "inherit"
        },
        "border": {
            "width": "0"
        },
        "dimensions": {
            "minHeight": "0"
        },
        "css": "&::before { content: var(--wp--custom--mark--separator); display: block; }"
    }
}
```

### Image variation with companion stylesheet — `styles/block/image/sketch.json`

```json
{
    "$schema": "https://schemas.wp.org/trunk/theme.json",
    "version": 3,
    "title": "Field Sketch",
    "slug": "image-sketch",
    "blockTypes": ["core/image"],
    "styles": {
        "border": {
            "radius": "0"
        },
        "shadow": "0 0 0 1px var(--wp--preset--color--sketch-ink), 1.5px 1px 0 0.5px var(--wp--preset--color--sketch-ink), -1px 1.5px 0 0.5px var(--wp--preset--color--sketch-ink), 1px -1.5px 0 0.5px var(--wp--preset--color--sketch-ink), -1.5px -1px 0 0.5px var(--wp--preset--color--sketch-ink), 2px 0.5px 0 0 var(--wp--preset--color--sketch-ink), -0.5px 2px 0 0 var(--wp--preset--color--sketch-ink), 2.5px 1.5px 0 0 rgba(0,0,0,0.08), -1px -2px 0 0 rgba(0,0,0,0.06)",
        "spacing": {
            "padding": {
                "top": "var(--wp--preset--spacing--40)",
                "bottom": "var(--wp--preset--spacing--40)",
                "left": "var(--wp--preset--spacing--40)",
                "right": "var(--wp--preset--spacing--40)"
            }
        },
        "elements": {
            "caption": {
                "color": {
                    "text": "var(--wp--preset--color--sketch-ink)"
                },
                "spacing": {
                    "margin": {
                        "top": "var(--wp--preset--spacing--40)",
                        "bottom": "0"
                    }
                },
                "typography": {
                    "fontFamily": "var(--wp--preset--font-family--tertiary)",
                    "fontSize": "var(--wp--preset--font-size--sm)",
                    "lineHeight": "var(--wp--custom--line-height--sm)",
                    "textAlign": "center"
                }
            }
        }
    }
}
```

Companion stylesheet at `resources/scss/block/core/image.scss`:

```scss
.is-style-image-sketch {
    border: 1px solid color-mix(in oklab, var(--wp--preset--color--sketch-ink) 15%, transparent);
    border-radius: 2px 3px 2px 3px / 3px 2px 3px 2px;
    background-color: var(--wp--preset--color--sketch-parchment);
    transform: rotate(-1.8deg);
    transform-origin: center center;
    transition: transform 0.3s ease, box-shadow 0.3s ease;

    &:hover {
        transform: rotate(0deg) translateY(-2px);
        box-shadow: 0 8px 24px rgba(0,0,0,0.12);
    }

    > img {
        display: block;
        width: 100%;
        outline: 1px solid var(--wp--preset--color--sketch-ink);
    }
}
```

---

## What not to do

- Do not use `styles.css` for anything the schema can express with a
  structured property.
- Do not hardcode colour, spacing, or typography values — always use preset
  tokens.
- Do not leave more than 3 lines of raw CSS in the JSON `css` property —
  move it to a block stylesheet.
- Do not add margin to the outer block — let the pattern or block level
  control it.
- Do not add padding unless the variation's visual effect structurally
  requires it.
- Do not omit any of the five required top-level fields.
- Do not use a different `$schema` URL — it is always
  `https://schemas.wp.org/trunk/theme.json`.
- Do not put block style variations in `styles/section/` or section styles
  in `styles/block/`.
