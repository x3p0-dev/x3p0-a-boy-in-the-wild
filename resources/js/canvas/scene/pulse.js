/**
 * Pulse — slow radial vignette for deep winter and midwinter chapters.
 *
 * A barely perceptible darkening at the viewport edges that breathes on a
 * long sine cycle. The centre stays clean — the effect lives only in the
 * outer band, so the prose is never sat under anything. Think of it as the
 * room itself contracting and easing back, the way deep cold makes a space
 * feel like it's pressing in even when nothing has moved.
 *
 * Canvas class  : x3p0-canvas-scene--pulse
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: drawn once at mid-pulse, then static
 *
 * @file resources/js/canvas/scene/pulse.js
 */

import {setupCanvas, extractColour, withAlpha, createCleanup} from 'x3p0/canvas-utils';

const canvas = document.querySelector('.x3p0-canvas-scene--pulse');

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// Where the vignette begins, as a fraction of the centre-to-corner
	// distance. Everything inside this radius stays fully transparent so the
	// reading area is never darkened.
	innerRadius: 0.42,

	// Where the vignette reaches maximum darkness, as a fraction of the
	// centre-to-corner distance. 1.0 places full darkness at the corners.
	outerRadius: 1.0,

	// Edge darkness — per-stop alpha applied on top of the token's alpha.
	// The sine drives this value between min and max each cycle.
	alphaMin: 0.03,
	alphaMax: 0.09,

	// Length of one full breath, in milliseconds. Long enough to feel like
	// the room shifting rather than an animation.
	pulseDuration: 14000
};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

(() => {
	const map = {
		innerRadius:   Number,
		outerRadius:   Number,
		alphaMin:      Number,
		alphaMax:      Number,
		pulseDuration: Number
	};

	Object.keys(map).forEach((key) => {
		if (canvas.dataset[key] !== undefined) {
			CONFIG[key] = map[key](canvas.dataset[key]);
		}
	});
})();

// ─── CANVAS SETUP ────────────────────────────────────────────────────────────

const rafRef = {current: null};

const {ctx, resize} = setupCanvas(canvas);

// ─── REDUCED MOTION ──────────────────────────────────────────────────────────

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// ─── COLOUR ──────────────────────────────────────────────────────────────────

let edge = extractColour(canvas, '--wp--preset--color--parchment-surface', '14,18,16,1');

// ─── DRAW ────────────────────────────────────────────────────────────────────

function drawFrame(edgeAlpha) {
	const W = window.innerWidth;
	const H = window.innerHeight;

	ctx.clearRect(0, 0, W, H);

	const cx     = W / 2;
	const cy     = H / 2;
	const corner = Math.sqrt(cx * cx + cy * cy);
	const inner  = corner * CONFIG.innerRadius;
	const outer  = corner * CONFIG.outerRadius;

	const grad = ctx.createRadialGradient(cx, cy, inner, cx, cy, outer);
	grad.addColorStop(0, withAlpha(edge, 0));
	grad.addColorStop(1, withAlpha(edge, edgeAlpha));

	ctx.fillStyle = grad;
	ctx.fillRect(0, 0, W, H);
}

// ─── REDUCED MOTION — draw once at mid-pulse, then stop ──────────────────────

if (reducedMotion) {
	drawFrame((CONFIG.alphaMin + CONFIG.alphaMax) / 2);
	createCleanup(canvas, rafRef, resize);
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
	function tick(timestamp) {
		const phase     = (timestamp % CONFIG.pulseDuration) / CONFIG.pulseDuration;
		const breath    = 0.5 + 0.5 * Math.sin(phase * Math.PI * 2);
		const edgeAlpha = CONFIG.alphaMin + (CONFIG.alphaMax - CONFIG.alphaMin) * breath;

		drawFrame(edgeAlpha);
		rafRef.current = requestAnimationFrame(tick);
	}

	rafRef.current = requestAnimationFrame(tick);
	createCleanup(canvas, rafRef, resize);
}
