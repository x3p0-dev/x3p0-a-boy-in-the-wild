---
name: php-style
description: >
  PHP coding standards and style guide. Use this skill before writing, editing,
  or reviewing any PHP code — including functions, classes, hooks, filters,
  snippets, and pattern files. Trigger on any request that will produce PHP
  output: "add a filter", "write a function", "how do I hook into X", "fix this
  PHP", "show me the code for", or any task where PHP will appear in the
  response. Read this before writing a single line of PHP.
---

# PHP Style Guide

Read this before writing any PHP. All rules apply unless the file path is
explicitly noted as an exception.

---

## The non-negotiables

**Tabs, not spaces.** The single most important rule.

**No spaces inside parentheses** — function calls, control structures,
declarations:

```php
// Correct
if ($condition) {
}

esc_html($title);
absint($id);

// Wrong
if ( $condition ) {
esc_html( $title );
```

**Spaces around operators:**

```php
$total = $a + $b;
$label = $prefix . $suffix;
$valid = $count > 0 && $enabled === true;
```

**One space after control structure keywords** (`if`, `else`, `elseif`,
`foreach`, `while`, `for`, `switch`, `match`, `try`, `catch`):

```php
if ($condition) {
	// ...
} elseif ($other) {
	// ...
}

foreach ($items as $key => $value) {
	// ...
}
```

---

## File structure

- UTF-8 encoding, Unix line endings
- One blank line at end of file
- No closing `?>` tag
- `declare(strict_types=1)` in all non-pattern PHP files

```php
<?php

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding\Sources;

use X3P0\ABoyInTheWild\Contracts\Bootable;
use WP_Block;
```

Imports grouped: PHP standard library → WordPress → internal. Blank line
between groups. No leading backslash on imported class names.

---

## Classes

Opening brace on its own line. One blank line between methods. Visibility on
every method and property. `abstract`/`final` before visibility; `static`
after.

```php
class Story implements Bootable
{
	public function boot(): void
	{
		// ...
	}
}
```

---

## Security — non-negotiable

Escape all output using the most specific function for the context:

```php
echo esc_html($title);
echo esc_attr($class);
echo esc_url($permalink);
echo wp_kses_post($content);
```

Sanitise all input — no raw `$_GET`, `$_POST`, or `$_REQUEST`:

```php
$id = absint($_GET['id'] ?? 0);
$slug = sanitize_key($_POST['slug'] ?? '');
```

Use nonces for any form submission or URL-based action.

---

## Database queries

Always use `$wpdb->prepare()` for queries with variable input. Never
concatenate variables into query strings.

```php
$results = $wpdb->get_results(
	$wpdb->prepare(
		'SELECT * FROM %i WHERE post_status = %s',
		$wpdb->posts,
		'publish'
	)
);
```

---

## PHP version

Target PHP 8.1+. Use freely: named arguments, union types, `match`
expressions, nullsafe operator (`?->`), constructor property promotion,
`str_contains()` / `str_starts_with()` / `str_ends_with()`, enums, `readonly`
properties.

Avoid PHP 8.2+ features (readonly classes, DNF types, standalone
`true`/`false`/`null` types) unless the minimum version is explicitly raised.

---

## Line length

Not enforced. Don't wrap long strings — block markup, SQL queries, translated
strings — artificially. Wrap only when it genuinely aids readability.

---

## Patterns (`patterns/` path)

Relaxed rules for pattern files:

- `WordPress.WP.GlobalVariablesOverride` — not enforced (short variable names
  like `$post` and `$args` are acceptable)
- `Generic.WhiteSpace.ScopeIndent.Incorrect` — not enforced (block markup
  mixed with PHP produces non-standard indentation)
- `Squiz.WhiteSpace.ControlStructureSpacing.SpacingAfterOpen` — not enforced
  (single-statement bodies may omit the blank line after the opening brace)
- `declare(strict_types=1)` — may be omitted

---

## What `file_get_contents()` is fine

`file_get_contents()` is permitted for local file reads. The sniff recommending
`wp_remote_get()` instead is excluded — it's inappropriate for local reads.
