/**
 * Lost terrain — flow-field contour lines suggesting unmapped ground.
 *
 * Used by the 404 page. Adapted from the spine arc's flow-field effect but
 * retuned for disorientation: three asymmetric sine harmonics produce a
 * field that drifts without settling. The spine terrain feels like known
 * ground. This terrain has no name because no one has walked it before.
 *
 * Each seed traces a line through the field, stepping `stepSize` pixels
 * along the field's local direction at every iteration, for `lineLength`
 * iterations or until the line wanders off the viewport.
 *
 * Canvas class  : x3p0-canvas-scene--lost-terrain
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized, drawn once at t=0, then static
 *
 * @file resources/js/canvas/scene/lost-terrain.js
 */

import {setupCanvas, extractColour, withAlpha, createCleanup} from 'x3p0/canvas-utils';

const canvas = document.querySelector('.x3p0-canvas-scene--lost-terrain');

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// Number of seed lines.
	lineCount: 260,

	// Maximum steps per line before it stops.
	lineLength: 220,

	// Distance (px) between successive points along a line.
	stepSize: 3.8,

	// Per-line alpha range.
	alphaMin: 0.04,
	alphaMax: 0.11,

	// Per-line stroke width range (px).
	widthMin: 0.4,
	widthMax: 0.9,

	// How fast the field drifts over time. Lower = slower, more disorienting.
	driftSpeed: 0.0015,

	// Field harmonics — three asymmetric sine layers.
	harmonic1Freq: 0.008,
	harmonic1Amp:  1.0,
	harmonic2Freq: 0.013,
	harmonic2Amp:  0.5,
	harmonic3Freq: 0.022,
	harmonic3Amp:  0.25,

	// How far past the viewport edge a line is allowed to wander before it
	// terminates (px). Prevents lines from looping in off-screen space.
	wanderMargin: 20
};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

(() => {
	const map = {
		lineCount:     Number,
		lineLength:    Number,
		stepSize:      Number,
		alphaMin:      Number,
		alphaMax:      Number,
		widthMin:      Number,
		widthMax:      Number,
		driftSpeed:    Number,
		harmonic1Freq: Number,
		harmonic1Amp:  Number,
		harmonic2Freq: Number,
		harmonic2Amp:  Number,
		harmonic3Freq: Number,
		harmonic3Amp:  Number,
		wanderMargin:  Number
	};

	Object.keys(map).forEach((key) => {
		if (canvas.dataset[key] !== undefined) {
			CONFIG[key] = map[key](canvas.dataset[key]);
		}
	});
})();

// ─── CANVAS SETUP ────────────────────────────────────────────────────────────

const rafRef = {current: null};

let seeds = [];

const {ctx, resize} = setupCanvas(canvas, () => {
	seeds = buildSeeds();
});

// ─── REDUCED MOTION ──────────────────────────────────────────────────────────

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// ─── COLOUR ──────────────────────────────────────────────────────────────────

// `--rule` carries low alpha (0.14 in mood-lost) — that subtlety is
// intentional. withAlpha() multiplies it through per-line.
let colour = extractColour(canvas, '--wp--preset--color--rule', '185,165,85,0.14');

// ─── EFFECT STATE ────────────────────────────────────────────────────────────

function randomBetween(min, max) {
	return min + Math.random() * (max - min);
}

function buildSeeds() {
	const list = [];
	for (let i = 0; i < CONFIG.lineCount; i++) {
		list.push({
			x0:    Math.random() * window.innerWidth,
			y0:    Math.random() * window.innerHeight,
			alpha: randomBetween(CONFIG.alphaMin, CONFIG.alphaMax),
			width: randomBetween(CONFIG.widthMin, CONFIG.widthMax)
		});
	}
	return list;
}

function fieldAngle(x, y, t) {
	const a1 = Math.sin(x * CONFIG.harmonic1Freq + t * 0.7)
		* Math.cos(y * CONFIG.harmonic1Freq * 0.9 + t * 0.5)
		* CONFIG.harmonic1Amp;
	const a2 = Math.sin(x * CONFIG.harmonic2Freq - y * CONFIG.harmonic2Freq * 1.1 + t * 0.4)
		* CONFIG.harmonic2Amp;
	const a3 = Math.cos(x * CONFIG.harmonic3Freq * 0.8 + y * CONFIG.harmonic3Freq + t * 0.3)
		* CONFIG.harmonic3Amp;
	return (a1 + a2 + a3) * Math.PI;
}

// ─── DRAW ────────────────────────────────────────────────────────────────────

function draw(t) {
	const W = window.innerWidth;
	const H = window.innerHeight;
	const M = CONFIG.wanderMargin;

	ctx.clearRect(0, 0, W, H);
	ctx.lineCap = 'round';

	for (const s of seeds) {
		let x = s.x0;
		let y = s.y0;

		ctx.strokeStyle = withAlpha(colour, s.alpha);
		ctx.lineWidth   = s.width;
		ctx.beginPath();
		ctx.moveTo(x, y);

		for (let step = 0; step < CONFIG.lineLength; step++) {
			const angle = fieldAngle(x, y, t);
			x += Math.cos(angle) * CONFIG.stepSize;
			y += Math.sin(angle) * CONFIG.stepSize;
			ctx.lineTo(x, y);

			if (x < -M || x > W + M || y < -M || y > H + M) break;
		}

		ctx.stroke();
	}
}

// ─── REDUCED MOTION — draw once, then stop ───────────────────────────────────

if (reducedMotion) {
	draw(0);
	createCleanup(canvas, rafRef, resize);
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
	let t = 0;

	function tick() {
		draw(t);
		t += CONFIG.driftSpeed;
		rafRef.current = requestAnimationFrame(tick);
	}

	rafRef.current = requestAnimationFrame(tick);
	createCleanup(canvas, rafRef, resize);
}
