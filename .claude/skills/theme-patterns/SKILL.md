---
name: theme-patterns
description: >
  Building patterns for the A Boy in the Wild theme. Use this skill before
  writing or modifying any pattern file in this theme. Covers the folder
  structure, pattern types, naming conventions, categories, and how the
  design system connects to patterns. Read wp-patterns first for WordPress
  pattern fundamentals. Triggers on: "build a chapter pattern", "add a
  fragment", "create a canvas pattern", "write a query pattern", or any task
  that produces a file under patterns/ in this theme.
---

# Theme Patterns

Read wp-patterns before this skill. This skill covers conventions specific
to the A Boy in the Wild theme.

---

## Pattern types and folder structure

```
patterns/
├── chapters/           — chapter and buried chapter patterns
├── canvas/             — canvas scene patterns
├── chapter-elements/   — composed elements used in chapter patterns
├── template/           — full template patterns (PHP required)
├── query/              — Query Loop patterns
└── fragment/           — single-block data fragments
```

---

## Chapter patterns

**Folder:** `patterns/chapters/`
**Categories:** `x3p0-chapters` (public), `x3p0-chapters-buried` (buried)

Chapter patterns are the most complex patterns in the theme. Before designing
or building any chapter pattern, read the chapter-design skill. The structure
of every chapter pattern follows from its design — there is no fixed template
to follow.

### File naming

- Public chapters: `chapter-{number}.php` — zero-padded three digits
- Buried chapters: `chapter-{number}-buried.php`

Examples: `chapter-001.php`, `chapter-001-buried.php`, `chapter-042.php`

### Fixed rules

Three things are fixed regardless of design:

**1. The Entry Group always carries a section style variation.**
The outermost Group block always has a section style class that controls the
chapter's full colour world. See the chapter-design skill for variation types
and slugs:

```
"className":"is-style-section-{type}-{variation}"
```

**2. The Waypoint is always present.**
Every chapter pattern includes the site waypoint (persistent header). Its
position and wrapper may vary per the chapter's design, but it must always
be present.

**3. Story Navigation is always present.**
Every chapter pattern includes the story navigation (previous/next links).
Its position and wrapper may vary per the chapter's design, but it must
always be present.

**4. Canvas scene patterns, when used, are always the last child of Entry.**
Canvas effects are optional. When a chapter uses a scene canvas, the canvas
pattern reference is always placed as the final child inside the Entry Group.
Other canvas types may have different placements:

```
<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/canvas-scene-{effect}"} /-->
```

Everything else — layer structure, layout, header, footer, content — is a
design decision. Read the chapter-design skill before making any of those
decisions.

---

## Canvas patterns

**Folder:** `patterns/canvas/`
**Categories:** `x3p0-canvas-scenes` (for scene-type canvases; other types
will have their own categories)

Canvas patterns contain a single `wp:html` block with the canvas element.

### File naming

Single effect: `canvas-{type}-{effect}.php`
Multiple effects: `canvas-{type}-{effect}-{effect}.php`

Examples: `canvas-scene-adrift.php`, `canvas-scene-snow-embers.php`

### Structure

```php
<?php
/**
 * Title: Animation: {Effect Name}
 * Slug: x3p0-a-boy-in-the-wild/canvas-{type}-{effect}
 * Description: Brief description of the visual effect.
 * Categories: x3p0-canvas-scenes
 * Inserter: yes
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;
?>

<!-- wp:html -->
<!-- Animation canvas. Do not alter unless you know what you're doing! -->
<canvas class="x3p0-canvas-scene x3p0-canvas-scene--{effect}" aria-hidden="true"></canvas>
<!-- /wp:html -->
```

See the canvas-effects skill before writing or modifying any canvas script.

---

## Fragment patterns

**Folder:** `patterns/fragment/`
**Category:** `x3p0-fragments`

Fragments are single-block patterns that output one discrete piece of
content. They are the smallest composable unit. Fragments can be scoped to
any data source — chapters, site data, or anything else. The scope is
reflected in the name.

### File naming

`fragment-{scope}-{field}.php`

Examples: `fragment-chapter-season.php`, `fragment-chapter-year.php`,
`fragment-site-copyright.php`

### Structure

A fragment is typically a single block, often with a block binding. The
fallback text should be a translatable placeholder matching what the binding
outputs:

```php
<?php
/**
 * Title: Chapter Season
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-season
 * Description: Displays a chapter's season.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;
?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr__('Season', 'x3p0-a-boy-in-the-wild') ?>",
		"bindings":{
			"content":{
				"source":"x3p0/chapter",
				"args":{"field":"season"}
			}
		}
	}
} -->
<p><?= esc_html__('Season', 'x3p0-a-boy-in-the-wild') ?></p>
<!-- /wp:paragraph -->
```

Not all fragments use block bindings. A fragment may be any single block that
outputs a discrete piece of content.

---

## Chapter element patterns

**Folder:** `patterns/chapter-elements/`
**Category:** `x3p0-chapter-elements`

Chapter elements are composed groups of blocks or other patterns used in
chapter patterns. They include the waypoint, story navigation, chapter
dateline, and other reusable chapter-level components. There is no fixed
naming prefix — names are descriptive and reflect the element's purpose.

### File naming

Descriptive slug, no fixed prefix:

Examples: `chapter-dateline.php`, `waypoint-content-chapter.php`,
`story-navigation-default.php`, `story-navigation-content.php`

---

## Query patterns

**Folder:** `patterns/query/`
**Category:** `x3p0-template-elements`
**Block Types:** `core/query`

Query patterns contain the full Query Loop block with its inner Post Template
and all nested blocks. Designed to be embedded in template patterns or other
patterns.

### File naming

`query-{name}.php`

Example: `query-trail.php`

---

## Template patterns

**Folder:** `patterns/template/`
**Inserter:** `no` (always)
**Categories:** omitted

Template patterns are full page layouts that require PHP access. WordPress
HTML templates cannot contain PHP, so template patterns are used instead. A
template HTML file contains a single pattern reference:

```
<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/template-{name}"} /-->
```

### File naming

`template-{name}.php`

Example: `template-home.php`

---

## Text domain

All translatable strings use `'x3p0-a-boy-in-the-wild'` as the text domain:

```php
esc_html__('Season', 'x3p0-a-boy-in-the-wild')
esc_attr__('Chapter Header', 'x3p0-a-boy-in-the-wild')
```

---

## What not to do

- Do not design or build a chapter pattern without reading the chapter-design
  skill first.
- Do not build a chapter pattern without a section style variation on the
  Entry Group.
- Do not omit the Waypoint or Story Navigation from any chapter pattern.
- Do not place a canvas scene pattern anywhere other than as the last child
  of the Entry Group.
- Do not put chapter patterns in any folder other than `patterns/chapters/`.
- Do not add `Categories` to template patterns — they are not in the
  inserter.
- Do not omit `declare(strict_types=1)` and the `ABSPATH` guard from any
  pattern file, even minimal ones.
