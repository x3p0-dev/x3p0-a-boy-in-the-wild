/**
 * Rising embers — soft embers drifting upward from the bottom of the viewport.
 *
 * Used by Chapter 001 ("He Made a Fire"). The embers rise because he made a
 * fire. Particles wobble horizontally, flicker in size, and fade as they rise.
 * Additive blending lets overlapping cores stack into a warmer glow without
 * needing multiple colour variants — the hue is the chapter's ink-accent.
 *
 * Canvas class  : x3p0-canvas-scene--rising-embers
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized but not drawn (a static frame of embers
 *                 mid-flight would read as debris, not embers)
 *
 * @file resources/js/canvas/scene/rising-embers.js
 */

import {setupCanvas, extractColour, withAlpha, createCleanup} from 'x3p0/canvas-utils';

const canvas = document.querySelector('.x3p0-canvas-scene--rising-embers');

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// Number of ember particles on screen at once.
	emberCount: 22,

	// Horizontal spawn range, as a fraction of viewport width (0–1).
	originXMin: 0.00,
	originXMax: 1.00,

	// Vertical spawn range, as a fraction of viewport height (0–1).
	// Embers spawn near the bottom and rise.
	originYMin: 0.80,
	originYMax: 1.00,

	// Rise speed range (px/frame). Negative values move upward.
	riseSpeedMin: -0.45,
	riseSpeedMax: -0.18,

	// Base horizontal drift range (px/frame).
	driftXMin: -0.20,
	driftXMax:  0.20,

	// Wobble — horizontal sine oscillation layered on top of drift.
	wobbleSpeedMin: 0.006,  // radians/frame
	wobbleSpeedMax: 0.022,
	wobbleAmpMin:   0.08,   // px
	wobbleAmpMax:   0.45,

	// Base particle radius range (px). Final radius adds the flicker offset.
	radiusMin: 1.0,
	radiusMax: 2.6,

	// Glow halo radius as a multiplier of the particle's base radius.
	glowRadiusMultiplier: 4.5,

	// Per-particle alpha range. Kept low — embers should be subtle.
	alphaMin: 0.18,
	alphaMax: 0.48,

	// Per-particle fade rate (alpha lost per frame).
	fadeRateMin: 0.0012,
	fadeRateMax: 0.0028,

	// Flicker — sine oscillation applied to radius around its base value.
	flickerSpeedMin: 0.04,   // radians/frame
	flickerSpeedMax: 0.10,
	flickerAmpMin:   0.12,   // px
	flickerAmpMax:   0.32
};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

(() => {
	const map = {
		emberCount:           Number,
		originXMin:           Number,
		originXMax:           Number,
		originYMin:           Number,
		originYMax:           Number,
		riseSpeedMin:         Number,
		riseSpeedMax:         Number,
		driftXMin:            Number,
		driftXMax:            Number,
		wobbleSpeedMin:       Number,
		wobbleSpeedMax:       Number,
		wobbleAmpMin:         Number,
		wobbleAmpMax:         Number,
		radiusMin:            Number,
		radiusMax:            Number,
		glowRadiusMultiplier: Number,
		alphaMin:             Number,
		alphaMax:             Number,
		fadeRateMin:          Number,
		fadeRateMax:          Number,
		flickerSpeedMin:      Number,
		flickerSpeedMax:      Number,
		flickerAmpMin:        Number,
		flickerAmpMax:        Number
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

// The ember hue is the chapter's warm anchor. Additive blending in the draw
// loop is what gives the cores their brightened, glowing feel — there is no
// per-particle colour variation.
let colour = extractColour(canvas, '--wp--preset--color--ink-accent', '122,64,16');

// ─── EFFECT STATE ────────────────────────────────────────────────────────────

function randomBetween(min, max) {
	return min + Math.random() * (max - min);
}

function createEmber() {
	const baseRadius = randomBetween(CONFIG.radiusMin, CONFIG.radiusMax);

	return {
		x:            window.innerWidth  * randomBetween(CONFIG.originXMin, CONFIG.originXMax),
		y:            window.innerHeight * randomBetween(CONFIG.originYMin, CONFIG.originYMax),
		baseRadius,
		radius:       baseRadius,
		vy:           randomBetween(CONFIG.riseSpeedMin,    CONFIG.riseSpeedMax   ),
		vx:           randomBetween(CONFIG.driftXMin,       CONFIG.driftXMax      ),
		wobble:       randomBetween(0, Math.PI * 2),
		wobbleSpeed:  randomBetween(CONFIG.wobbleSpeedMin,  CONFIG.wobbleSpeedMax ),
		wobbleAmp:    randomBetween(CONFIG.wobbleAmpMin,    CONFIG.wobbleAmpMax   ),
		alpha:        randomBetween(CONFIG.alphaMin,        CONFIG.alphaMax       ),
		fadeRate:     randomBetween(CONFIG.fadeRateMin,     CONFIG.fadeRateMax    ),
		flicker:      randomBetween(0, Math.PI * 2),
		flickerSpeed: randomBetween(CONFIG.flickerSpeedMin, CONFIG.flickerSpeedMax),
		flickerAmp:   randomBetween(CONFIG.flickerAmpMin,   CONFIG.flickerAmpMax  )
	};
}

// Stagger initial positions across the viewport so the first frame isn't empty.
const embers = Array.from({length: CONFIG.emberCount}, () => {
	const e = createEmber();
	e.y     = window.innerHeight * randomBetween(0.20, 1.00);
	e.alpha = randomBetween(CONFIG.alphaMin * 0.3, CONFIG.alphaMax);
	return e;
});

// ─── DRAW ────────────────────────────────────────────────────────────────────

function drawEmber(e) {
	if (e.alpha <= 0) return;

	const glowRadius = e.radius * CONFIG.glowRadiusMultiplier;

	const glow = ctx.createRadialGradient(e.x, e.y, 0, e.x, e.y, glowRadius);
	glow.addColorStop(0, withAlpha(colour, e.alpha * 0.35));
	glow.addColorStop(1, withAlpha(colour, 0));

	ctx.beginPath();
	ctx.arc(e.x, e.y, glowRadius, 0, Math.PI * 2);
	ctx.fillStyle = glow;
	ctx.fill();

	const core = ctx.createRadialGradient(e.x, e.y, 0, e.x, e.y, e.radius);
	core.addColorStop(0,   withAlpha(colour, Math.min(e.alpha * 1.2, 1)));
	core.addColorStop(0.6, withAlpha(colour, e.alpha));
	core.addColorStop(1,   withAlpha(colour, 0));

	ctx.beginPath();
	ctx.arc(e.x, e.y, e.radius, 0, Math.PI * 2);
	ctx.fillStyle = core;
	ctx.fill();
}

function draw() {
	ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);
	ctx.globalCompositeOperation = 'lighter';

	for (let i = 0; i < embers.length; i++) {
		const e = embers[i];

		e.wobble  += e.wobbleSpeed;
		e.flicker += e.flickerSpeed;
		e.x       += e.vx + Math.sin(e.wobble) * e.wobbleAmp;
		e.y       += e.vy;
		e.radius   = e.baseRadius + Math.sin(e.flicker) * e.flickerAmp;
		e.alpha   -= e.fadeRate;

		drawEmber(e);

		if (e.alpha <= 0 || e.y < -20) {
			embers[i] = createEmber();
		}
	}

	ctx.globalCompositeOperation = 'source-over';
}

// ─── REDUCED MOTION — skip drawing entirely ──────────────────────────────────

if (reducedMotion) {
	createCleanup(canvas, rafRef, resize);
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
	function tick() {
		draw();
		rafRef.current = requestAnimationFrame(tick);
	}

	rafRef.current = requestAnimationFrame(tick);
	createCleanup(canvas, rafRef, resize);
}
