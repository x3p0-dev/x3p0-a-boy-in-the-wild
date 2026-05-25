---
name: canvas-effects
description: >
  Writing, modifying, and maintaining canvas-based atmospheric effects for
  the A Boy in the Wild theme. Use this skill before writing any canvas
  JavaScript, creating a new canvas effect, modifying an existing one, or
  adding a canvas element to a chapter pattern. Triggers on: "add a canvas
  effect", "write a canvas script", "new canvas for chapter X", "modify the
  flow field", "update snow embers", or any task that touches files in
  resources/js/canvas/.
---

# Canvas Effects

Read this before writing or modifying any canvas script. All effects must
follow the module pattern described here. Any IIFE-wrapped files in the
codebase are legacy — do not follow their pattern.

---

## The core principle

Every canvas effect must be grounded in the chapter's physical world or
emotional register. If the effect cannot be stated plainly — *the rain falls
because it was raining* — it doesn't belong. Effects should be noticed on
arrival and then forgotten. They must never compete with the prose.

---

## File locations

```
resources/js/canvas/
├── utils.js                  — shared utilities (import from here)
└── scene/
    └── {effect}.js           — one file per effect, module pattern
```

After build, files move from `resources/` to `public/`. Import paths in
source always use the `resources/` tree.

---

## The HTML element

Every scene canvas is placed as a direct child of the Entry Group block in
the chapter pattern:

```html
<canvas
	class="x3p0-canvas-scene x3p0-canvas-scene--{effect}"
	aria-hidden="true"
></canvas>
```

- `x3p0-canvas-scene` — base class, handles all positioning via CSS
- `x3p0-canvas-scene--{effect}` — BEM modifier, named for what the effect
  does (not which chapter). Same script may serve multiple chapters with
  different `data-*` tuning
- `aria-hidden="true"` — always present; the canvas is decorative

Do not set `width` or `height` attributes on the element — sizing is handled
in JavaScript.

---

## CSS

Scene canvas positioning is handled globally by the theme stylesheet. No
per-effect CSS is needed or written:

```css
.wp-block-group:has(.x3p0-canvas-scene) > *:not(.x3p0-canvas-scene) {
    position: relative;
    z-index: 1;
}

.x3p0-canvas-scene {
    position: fixed;
    z-index: 0;
    inset: 0;
    width: 100%;
    max-width: 100% !important;
    height: 100%;
    margin: 0 !important;
    pointer-events: none;
}
```

Do not add per-effect positioning rules.

---

## Shared utilities (`resources/js/canvas/utils.js`)

All new effects import from the shared utilities module via the bare
specifier `x3p0/canvas-utils`. The specifier is externalized by webpack
(see `webpack.config.js` — `requestToExternalModule`) and resolved at
runtime through the WordPress Script Modules import map, so the file is
fetched once per page rather than bundled into every scene.

If `utils.js` does not exist, create it with the exports below before
writing the effect.

```js
/**
 * Set up a canvas with DPR-aware sizing and a resize handler.
 *
 * @param {HTMLCanvasElement} canvas
 * @param {Function}          onResize - called after each resize (optional)
 * @returns {{ ctx: CanvasRenderingContext2D, resize: Function }}
 */
export function setupCanvas(canvas, onResize = null) {
    const ctx = canvas.getContext('2d');

    function resize() {
        const dpr     = window.devicePixelRatio || 1;
        canvas.width  = window.innerWidth  * dpr;
        canvas.height = window.innerHeight * dpr;
        ctx.setTransform(1, 0, 0, 1, 0, 0);
        ctx.scale(dpr, dpr);
        if (onResize) onResize();
    }

    resize();
    window.addEventListener('resize', resize);
    return { ctx, resize };
}

/**
 * Read a CSS custom property from the canvas element, strip its alpha
 * channel, and return the bare RGB components as a comma-separated string
 * for use in rgba() construction.
 *
 * Scene canvases inherit CSS custom properties from the Entry Group, so
 * reading from the canvas directly is equivalent to reading from the group.
 *
 * @param {HTMLCanvasElement} canvas
 * @param {string}            token     - CSS custom property name (with --)
 * @param {string}            fallback  - fallback RGB string, e.g. '90,55,12'
 * @returns {string}
 */
export function extractRGB(canvas, token, fallback) {
    const raw   = getComputedStyle(canvas).getPropertyValue(token).trim()
        || fallback;
    const match = raw.match(/[\d.]+/g);

    return (match && match.length >= 3)
        ? `${match[0]},${match[1]},${match[2]}`
        : fallback;
}

/**
 * Register a MutationObserver that cancels the animation frame and removes
 * the resize listener when the canvas is removed from the DOM.
 *
 * @param {HTMLCanvasElement}   canvas
 * @param {{ current: number }} rafRef  - object with a .current RAF id
 * @param {Function}            resize  - the resize function to remove
 */
export function createCleanup(canvas, rafRef, resize) {
    const observer = new MutationObserver(() => {
        if (!document.contains(canvas)) {
            cancelAnimationFrame(rafRef.current);
            window.removeEventListener('resize', resize);
            observer.disconnect();
        }
    });

    observer.observe(document.body, { childList: true, subtree: true });
}
```

---

## Script structure

Every effect file follows this structure, in order:

1. File header comment
2. Imports from utils
3. Canvas lookup
4. CONFIG block — all tuneable values
5. Data attribute overrides
6. Canvas setup via `setupCanvas()`
7. Reduced motion check
8. Colour — read from CSS custom property via `extractRGB()`
9. Effect-specific state (particles, field, seeds, etc.)
10. Draw function(s)
11. Animation loop — or static draw if reduced motion
12. Cleanup via `createCleanup()`

The canvas element is guaranteed to exist when the module runs —
`CanvasScriptModuleLoader` only enqueues a scene module after it has
seen the matching trigger class in the rendered HTML. No `if (!canvas)`
guard is needed.

### Minimal template

```js
/**
 * {Effect name} — {one-line description}.
 *
 * {Two or three sentences: what the effect does, which chapter(s) use it,
 * and any notable behaviour (reduced motion, colour source, etc.)}
 *
 * Canvas class  : x3p0-canvas-scene--{effect}
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: {canvas is static / canvas draws once at t=0 / etc.}
 *
 * @file resources/js/canvas/scene/{effect}.js
 */

import { setupCanvas, extractRGB, createCleanup } from 'x3p0/canvas-utils';

const canvas = document.querySelector('.x3p0-canvas-scene--{effect}');

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {
    // All tuneable values here, one per line, with a comment.
    // Include unit and what the value controls.
    // e.g.:
    // particleCount: 60,      // number of particles
    // speedMin: 0.4,          // minimum fall speed (px/frame)
};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

( () => {
    const map = {
        // One entry per CONFIG key, paired with its type constructor.
        // e.g.:
        // particleCount: Number,
        // speedMin:      Number,
    };

    Object.keys(map).forEach((key) => {
        if (canvas.dataset[key] !== undefined) {
            CONFIG[key] = map[key](canvas.dataset[key]);
        }
    });
} )();

// ─── CANVAS SETUP ────────────────────────────────────────────────────────────

const rafRef = { current: null };

const { ctx, resize } = setupCanvas(canvas, () => {
    // Optional: anything that must re-run after resize (e.g. re-extract colour)
});

// ─── REDUCED MOTION ──────────────────────────────────────────────────────────

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// ─── COLOUR ──────────────────────────────────────────────────────────────────

let rgb = extractRGB(canvas, '--wp--preset--color--{token}', '{fallback-rgb}');

// ─── EFFECT STATE ────────────────────────────────────────────────────────────

// Particles, fields, seeds, etc.

// ─── DRAW ────────────────────────────────────────────────────────────────────

function draw(t = 0) {
    ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
    // ...
}

// ─── REDUCED MOTION — draw once, then stop ───────────────────────────────────

if (reducedMotion) {
    draw(0);
    createCleanup(canvas, rafRef, resize);
    // No animation loop.
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
    let t = 0;

    function tick() {
        // Advance t if the effect uses time drift.
        draw(t);
        rafRef.current = requestAnimationFrame(tick);
    }

    rafRef.current = requestAnimationFrame(tick);
    createCleanup(canvas, rafRef, resize);
}
```

---

## CONFIG rules

- Every tuneable value lives in `CONFIG`. No magic numbers in draw functions
  or particle constructors.
- Comment every key with its unit and what it controls.
- Group related values together.
- Every key in CONFIG must have a matching entry in the data attribute
  override map, even if it is unlikely to be overridden.

---

## Data attribute overrides

Any CONFIG key can be overridden from the HTML element:

```html
<canvas
    class="x3p0-canvas-scene x3p0-canvas-scene--{effect}"
    aria-hidden="true"
    data-particle-count="30"
    data-speed-min="0.2"
></canvas>
```

Attribute names use kebab-case; the browser converts them to camelCase in
`canvas.dataset`, matching CONFIG keys directly. Type coercion is explicit
via the `map` object — never rely on implicit conversion.

---

## Colour

- Always read colour from a CSS custom property on the canvas element using
  `extractRGB()`. Scene canvases inherit CSS custom properties from the
  Entry Group, so reading from the canvas directly is equivalent.
- Use the value directly as the RGB components of an `rgba()` string.
- Control opacity per-particle or per-line via `ctx.globalAlpha` or the
  alpha argument of `rgba()`.
- Always provide a hardcoded fallback matching the late-summer palette.

The most useful anchor tokens:

| Token | Role |
|---|---|
| `--wp--preset--color--ink-accent` | Darkest / most saturated, base hue |
| `--wp--preset--color--parchment-accent` | Mid tone, secondary hue |
| `--wp--preset--color--ink` | Foreground colour |
| `--wp--preset--color--rule` | Separator colour, subtle line effects |

---

## Reduced motion

- Always check `prefers-reduced-motion` before starting the animation loop.
- For effects where a static frame is meaningful (e.g. contour lines at
  t=0), draw once and stop.
- For effects where a static frame is not meaningful (e.g. particles),
  skip drawing entirely.
- The canvas must still exist in the DOM and be sized correctly in either
  case.

---

## Enqueuing

Scene modules are enqueued automatically — no per-effect PHP is required.

`CanvasScriptModuleLoader` (in `src/Block/Canvas/`) scans rendered Custom
HTML blocks for any `<canvas>` carrying a class of the form
`x3p0-canvas-{namespace}--{slug}`, and enqueues the matching module at
`public/js/canvas/{namespace}/{slug}.js` if its compiled `.asset.php`
exists. The
asset file's `dependencies` array is passed through to
`wp_enqueue_script_module()`, so anything webpack externalized — including
`x3p0/canvas-utils` — is resolved through the WordPress import map.

The shared utils module is registered once at theme boot by the same
loader (`registerSharedModules()`), so scenes that depend on it are wired
up without any per-effect work.

To ship a new effect, the only steps are:

1. Author `resources/js/canvas/scene/{effect}.js` per the template above.
2. Add the `<canvas>` HTML block to the chapter pattern.
3. Run the build.

---

## Writing a new effect

1. Confirm the effect is justified by the chapter's physical world or
   emotional register. State it plainly: *the embers rise because he made
   a fire.* If you can't state it plainly, reconsider.

2. Choose a colour anchor token from the table above. Decide on a fallback.

3. Create `resources/js/canvas/scene/{effect}.js` following the template.
   Put all tuneable values in CONFIG first — before writing any draw logic.

4. Add the `<canvas>` HTML block to the chapter pattern as a direct child
   of the Entry Group. Include any CONFIG overrides as `data-*` attributes.

5. Enqueue the script via PHP, scoped to the chapter post.

6. Test with `prefers-reduced-motion: reduce` enabled. The canvas must be
   present in the DOM and correctly sized, but completely still (or showing
   only the static t=0 frame if appropriate).

---

## Modifying an existing effect

- If the file uses an IIFE wrapper, refactor to the module pattern as part
  of the modification: drop the IIFE, add imports from `utils.js`, use
  `rafRef` for cleanup.
- All CONFIG values remain in CONFIG after modification — never move a
  tuneable value into a draw function to fix a bug.
- If adding a new tuneable, add it to both CONFIG and the data attribute
  override map.
- If changing colour behaviour, go through `extractRGB()` — do not
  hardcode colours except as fallbacks.

---

## What not to do

- Do not write an IIFE wrapper — module scope handles isolation.
- Do not add per-effect CSS positioning rules — `.x3p0-canvas-scene` covers it.
- Do not hardcode colours except as `extractRGB()` fallbacks.
- Do not put tuneable values anywhere except CONFIG.
- Do not add `width` or `height` attributes to the canvas element.
- Do not size the canvas to anything other than the viewport.
