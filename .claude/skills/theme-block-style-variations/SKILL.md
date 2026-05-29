---
name: theme-block-style-variations
description: >
  Creating and modifying block style variations and section styles for the
  A Boy in the Wild theme. Use this skill before creating any new style
  variation file, modifying an existing one, or choosing where a variation
  file should live. Read wp-block-style-variations first for WordPress
  fundamentals. Triggers on: "add a block style variation", "add a block
  style", "create a section style", "style this block differently", or any
  task that produces a file under styles/block/ or styles/section/.
---

# Block Style Variations — Theme Conventions

Read `wp-block-style-variations` before this skill. This skill covers
conventions specific to the A Boy in the Wild theme, including where this
theme's system overrides WordPress defaults.

---

## `styles/section/` — this theme's section styles

This theme overrides the WordPress `section-1`, `section-2` naming
convention with a semantic system. All section style files live at the top
level of `styles/section/`. Two subtypes:

### Chapter variations

Control the full color world of a chapter. Applied to the Entry Group block.

```
styles/section/{type}-{variation}.json
```

Slug: `section-{type}-{variation}`
Class: `is-style-section-{type}-{variation}`

Examples:
- `season-late-summer.json` → slug `section-season-late-summer`
- `arc-spine.json` → slug `section-arc-spine`
- `state-buried.json` → slug `section-state-buried`

### Container variations

Structural styles for container blocks. The tilde prefix sorts them
separately from chapter variations in the file system.

```
styles/section/~{type}.json
```

Slug: `container-{type}`
Class: `is-style-container-{type}`

Example: `~prose.json` → slug `container-prose`

---

## CSS custom property overrides in section styles

Section styles override palette presets via the `css` property. This keeps
the overrides visible and editable in the site editor's custom CSS panel,
which is the correct approach for this theme's editing experience. This is
the one exception to the 3-line CSS rule — palette preset overrides always
stay in the JSON regardless of length:

```json
"styles": {
    "css": "--wp--preset--color--ink: #160c02; --wp--preset--color--ink-subtle: #5c2c08; --wp--preset--color--parchment: #e8dfc0;"
}
```

Do not move these overrides to a stylesheet. They must be in the JSON to
apply at the correct scope.

---

## Block stylesheets — file paths

When a block variation's CSS exceeds 3 lines, the companion stylesheet lives
at:

```
resources/scss/block/{namespace}/{blockname}.scss
```

Compiled output: `public/css/block/{namespace}/{blockname}.css`

For core blocks:
- `resources/scss/block/core/image.scss`
- `resources/scss/block/core/paragraph.scss`

---

## What not to do

- Do not use the WordPress `section-1`, `section-2` naming for section
  styles — this theme uses semantic names.
- Do not move CSS custom property overrides out of section style JSON files.
- Do not put section styles in `styles/block/` or block styles in
  `styles/section/`.
