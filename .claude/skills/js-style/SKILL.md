---
name: js-style
description: >
  JavaScript coding standards and style guide. Use this skill before writing,
  editing, or reviewing any JavaScript in the theme — including Interactivity
  API stores, editor scripts, block variations, and canvas effects. Trigger on
  any request that will produce JS output: "add a store", "write a plugin",
  "fix this JS", "add a block variation", or any task where JavaScript will
  appear in the response. Read this before writing a single line of JS.
---

# JavaScript Style Guide

Read this before writing any JavaScript. All rules apply to all JS files in
the theme unless a more specific skill (e.g. canvas-effects) overrides them.

---

## The non-negotiables

**Tabs, not spaces.** The single most important rule.

**No spaces inside parentheses, brackets, or inline object braces:**

```js
// Correct
foo(bar)
[a, b]
{a: b}

// Wrong
foo( bar )
[ a, b ]
{ a: b }
```

**Spaces around operators:**

```js
const total = a + b;
const valid = count > 0 && enabled === true;
```

**Opening braces on the same line:**

```js
if (condition) {
	// ...
}

function draw(t) {
	// ...
}
```

**No trailing commas** — not in function calls, arrays, or object literals:

```js
// Correct
const items = [a, b, c];
foo(a, b, c);
const obj = {x: 1, y: 2};

// Wrong
const items = [a, b, c,];
```

---

## Naming

- **Component files** (React/JSX) use PascalCase — `ChapterAudioPanel.js`
- **All other files** use kebab-case — `chapter-audio.js`, `flow-field.js`
- **Store namespaces** use the theme prefix — `x3p0/chapter-audio`
- **Variables and functions** use camelCase — `rafRef`, `extractRGB`

---

## Imports

Group imports in this order, separated by a blank line:

1. WordPress packages
2. Theme-local modules

```js
import { store, getServerState } from '@wordpress/interactivity';

import { setupCanvas, extractRGB } from '../utils.js';
```

---

## JSX

Editor files use JSX. Do not import or use `createElement` — JSX is handled
by the Babel transform via `@wordpress/scripts`.

```js
// Correct
return (
	<Button variant="primary" onClick={open}>
		{__('Add to Archive', 'x3p0-a-boy-in-the-wild')}
	</Button>
);

// Wrong
return el(Button, {variant: 'primary', onClick: open}, __('Add to Archive', 'x3p0-a-boy-in-the-wild'));
```

Use `@wordpress/editor` for `PluginDocumentSettingPanel` — not
`@wordpress/edit-post`, which is deprecated since WordPress 6.6.

---

## Interactivity API stores

### Module-level variables

State that is not reactive — audio objects, interval references, cached
values — lives at module level outside the store. This keeps implementation
details out of the reactive state.

```js
let audio        = null;
let fadeInterval = null;
let targetVolume = 0.4;
let text         = {};
```

### Actions calling other actions

Actions call sibling actions via the destructured `actions` reference — never
by calling the function directly. Calling directly breaks the Interactivity
API's reactive context and will cause the store to stop working silently.

```js
const { state, actions } = store('x3p0/chapter-audio', {
	actions: {
		toggle() {
			if (!state.playing) {
				actions.start(); // Correct — via actions reference
			}
		},
		start() { ... }
	}
});
```

### Callbacks must match directives exactly

The callback name in the store must exactly match the directive in the markup.
No variations, no camelCase/kebab mismatches.

```html
<div data-wp-init="callbacks.init">
```

```js
callbacks: {
	init() { ... } // Must be init — not onInit, not initialize
}
```

### Internationalisation

Interactive scripts do not use `@wordpress/i18n` directly. Translated strings
are passed from PHP via `wp_interactivity_state()` and read once in JS via
`getServerState()`, stored in a module-level variable.

**PHP:**
```php
wp_interactivity_state('x3p0/chapter-audio', [
	'text' => [
		'listen' => __('Listen', 'x3p0-a-boy-in-the-wild'),
		'stop'   => __('Stop',   'x3p0-a-boy-in-the-wild'),
	]
]);
```

**JS:**
```js
import { store, getServerState } from '@wordpress/interactivity';

let text = {};

const serverState = getServerState('x3p0/chapter-audio');

store('x3p0/chapter-audio', {
	callbacks: {
		init() {
			text = serverState.text ?? {};
		}
	},
	state: {
		get label() {
			return state.playing ? (text.stop ?? 'Stop') : (text.listen ?? 'Listen');
		}
	}
});
```

Fallback strings on `??` are a safety net for cases where
`wp_interactivity_state()` was not called.

---

## Reduced motion

All animated scripts check `prefers-reduced-motion` once at module level
before starting any animation:

```js
const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

if (reducedMotion) {
	// Show content immediately, skip animation.
}
```

Do not check inside a loop or callback — check once and branch.
