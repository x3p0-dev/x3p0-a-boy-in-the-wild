---
name: wp-patterns
description: >
  WordPress block pattern conventions. Use this skill before writing,
  editing, or reviewing any pattern file — regardless of theme or project.
  Triggers on: "create a pattern", "write a pattern file", "add a pattern",
  "build a template pattern", or any task that produces a file under
  /patterns/. Read this before writing a single line of pattern markup.
---

# WordPress Block Patterns

Read this before writing or modifying any pattern file. These conventions
apply to all WordPress block theme patterns regardless of project.

---

## Registration

Patterns are auto-registered by WordPress when they exist as PHP files under
the theme's `/patterns` folder. No PHP registration code is needed.

Sub-folders within `/patterns` are allowed and used to organise patterns by
type. WordPress discovers all `.php` files recursively.

---

## File structure

Every pattern file follows this structure, in order:

1. Opening `<?php` tag
2. Registration header (docblock comment)
3. `declare(strict_types=1)`
4. `defined('ABSPATH') || exit` guard with comment
5. PHP variables (if needed)
6. Block markup

```php
<?php

/**
 * Title: Pattern Title
 * Slug: theme-slug/pattern-name
 * Description: Brief description.
 * Categories: theme-slug-category
 * Inserter: yes
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

$image = get_theme_file_uri('public/media/images/example.webp');
?>

<!-- block markup here -->
```

---

## Registration header

The docblock comment registers the pattern with WordPress. Required and
optional fields:

| Field | Required | Notes |
|---|---|---|
| `Title` | Yes | Human-readable. Shown in the inserter. |
| `Slug` | Yes | `{theme-slug}/{pattern-name}`. Must be unique. |
| `Description` | No | Brief description of the pattern's purpose. |
| `Categories` | No | Comma-separated list of pattern category slugs. |
| `Keywords` | No | Comma-separated. Used for inserter search. |
| `Block Types` | No | Comma-separated block type strings. Pattern appears as an option when that block type is selected in the inserter. |
| `Post Types` | No | Comma-separated. Restricts the pattern to specific post types. |
| `Template Types` | No | Comma-separated. Restricts the pattern to specific template types. |
| `Viewport Width` | No | Integer. Controls the preview scale in the inserter. |
| `Inserter` | No | `yes` or `no`. Defaults to `yes` if omitted. Set to `no` for patterns used only in templates or other patterns. |

```php
/**
 * Title: Chapter Dateline
 * Slug: theme-slug/chapter-dateline
 * Description: Displays the season and post excerpt as a dateline.
 * Categories: theme-slug-chapter-elements
 * Inserter: yes
 */
```

---

## PHP variables

Resolve dynamic values — image URLs, translated strings used in PHP context
— once at the top of the file, before the block markup. Never resolve them
inline inside the markup.

```php
$background = get_theme_file_uri('public/media/images/season-late-summer.webp');
$sketch     = get_theme_file_uri('public/media/images/chapter/001-clearing.webp');
```

---

## PHP output

Always use the short echo syntax `<?=` when outputting values in markup.
Never use `<?php echo`:

```php
// Correct
<?= esc_url($background) ?>
<?= esc_html__('Text', 'theme-slug') ?>

// Wrong
<?php echo esc_url($background); ?>
```

---

## Escaping

Always escape at the point of output. Never trust unescaped values in markup.

| Context | Function |
|---|---|
| Plain text | `esc_html__('Text', 'theme-slug')` |
| HTML attributes | `esc_attr__('Text', 'theme-slug')` |
| URLs | `esc_url($variable)` |
| HTML content (with allowed tags) | `wp_kses_post(__('Text', 'theme-slug'))` |

Use `esc_html__()` and `esc_attr__()` (with double underscores) for
translatable strings. Use `esc_html()` and `esc_attr()` (single underscore)
for non-translatable strings.

```php
<!-- Output a URL -->
"url":"<?= esc_url($background) ?>"

<!-- Output translatable text in an attribute -->
"name":"<?= esc_attr__('Chapter Header', 'theme-slug') ?>"

<!-- Output translatable plain text -->
<p><?= esc_html__('Season', 'theme-slug') ?></p>

<!-- Output translatable text containing HTML -->
<h1><?= wp_kses_post(__('<strong>Mostly</strong> <em>true</em>', 'theme-slug')) ?></h1>
```

---

## Block markup

### Syntax

Every block is written as an HTML comment containing the block name and
optional JSON attributes, followed by the block's HTML output.

**Standard block — opening and closing:**
```
<!-- wp:block-name {"attribute":"value"} -->
<div class="wp-block-block-name">
	...
</div>
<!-- /wp:block-name -->
```

**Self-closing block:**
```
<!-- wp:block-name {"attribute":"value"} /-->
```

**Block with no attributes:**
```
<!-- wp:paragraph -->
<p>Content here.</p>
<!-- /wp:paragraph -->
```

### Indentation

- Tabs, not spaces.
- Each nested block indents one level deeper than its parent.
- Opening comment, HTML element, inner content, closing HTML element, and
  closing comment all follow the same indentation level.

```
<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group">

	<!-- wp:paragraph -->
	<p>Indented one level.</p>
	<!-- /wp:paragraph -->

</div>
<!-- /wp:group -->
```

### JSON formatting

Simple blocks with one or two attributes use inline JSON:

```
<!-- wp:separator {"opacity":"css"} -->
```

Complex blocks with multiple attributes use multiline JSON, with each
property on its own line:

```
<!-- wp:group {
	"tagName":"main",
	"metadata":{"name":"<?= esc_attr__('Frame', 'text-domain') ?>"},
	"align":"full",
	"layout":{"type":"constrained"}
} -->
```

### Block metadata names

Significant blocks — those that form a named layer in the pattern — carry a
`metadata.name` property. This name appears in the editor's block list and
helps identify the block's purpose. Always translate metadata names:

```
"metadata":{"name":"<?= esc_attr__('Chapter Header', 'theme-slug') ?>"}
```

Omit `metadata.name` on minor inner blocks that don't need editor
identification.

### Pattern references

Embed another pattern using the `wp:pattern` self-closing block:

```
<!-- wp:pattern {"slug":"theme-slug/pattern-name"} /-->
```

---

## What not to do

- Do not use `<?php echo` for output — use the short echo syntax `<?=` instead.
- Do not register patterns via PHP (`register_block_pattern()`) — use the
  `/patterns` folder and registration header.
- Do not use spaces for indentation — tabs only.
- Do not resolve image URLs or other dynamic values inline in the markup —
  resolve them as PHP variables at the top of the file.
- Do not output unescaped values — always escape at the point of output with
  the correct function for the context.
- Do not omit `declare(strict_types=1)` or the `ABSPATH` guard.
- Do not omit `Title` or `Slug` from the registration header — both are
  required.
