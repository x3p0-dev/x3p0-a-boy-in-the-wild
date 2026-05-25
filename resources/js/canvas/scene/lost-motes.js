/**
 * Lost motes — particles drifting up through the moonbeam shaft.
 *
 * Used by the 404 page, layered above lost-moon and lost-terrain. Tiny
 * particles — dust, pollen, spore — rise slowly through the central beam,
 * drift laterally as they go, and fade once they wander outside the beam's
 * width. They are visible because the light catches them. They rise because
 * cold still air around something warm drives a slow vertical convection.
 *
 * Each particle has its own rise speed, lateral wobble, and phase, so the
 * field never appears choreographed.
 *
 * Canvas class  : x3p0-canvas-scene--lost-motes
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized but not drawn (mid-flight motes would
 *                 read as static specks, not motion)
 *
 * @file resources/js/canvas/scene/lost-motes.js
 */

import {setupCanvas, extractColour, withAlpha, createCleanup} from 'x3p0/canvas-utils';

const canvas = document.querySelector('.x3p0-canvas-scene--lost-motes');

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// Number of motes on screen at once.
	moteCount: 55,

	// Horizontal spawn range, as fractions of viewport width. Matches the
	// moonbeam shaft — centre third by default.
	originXMin: 0.34,
	originXMax: 0.66,

	// Vertical spawn range, as fractions of viewport height.
	originYMin: 0.30,
	originYMax: 1.05,

	// Rise speed range (px/frame). Negative = upward.
	riseSpeedMin: -0.22,
	riseSpeedMax: -0.07,

	// Linear horizontal drift range (px/frame). Combined with the sine
	// wobble below for the total lateral motion.
	driftXMin: -0.06,
	driftXMax:  0.06,

	// Lateral wobble — sinusoidal oscillation layered over linear drift.
	wobbleAmp:  0.55,    // px
	wobbleFreq: 0.012,   // base radians/frame; randomised per particle

	// Per-particle alpha range.
	alphaMin: 0.06,
	alphaMax: 0.28,

	// Alpha lost per frame when a mote drifts outside the beam x-range.
	fadeRate: 0.004,

	// Mote radius range (px).
	radiusMin: 0.6,
	radiusMax: 1.8,

	// Glow halo radius as a multiplier of the mote's core radius.
	glowRadiusMultiplier: 3.2,

	// Glow halo alpha as a fraction of the mote's current alpha.
	glowAlphaFraction: 0.18
};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

(() => {
	const map = {
		moteCount:            Number,
		originXMin:           Number,
		originXMax:           Number,
		originYMin:           Number,
		originYMax:           Number,
		riseSpeedMin:         Number,
		riseSpeedMax:         Number,
		driftXMin:            Number,
		driftXMax:            Number,
		wobbleAmp:            Number,
		wobbleFreq:           Number,
		alphaMin:             Number,
		alphaMax:             Number,
		fadeRate:             Number,
		radiusMin:            Number,
		radiusMax:            Number,
		glowRadiusMultiplier: Number,
		glowAlphaFraction:    Number
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

let colour = extractColour(canvas, '--wp--preset--color--ink-accent', '200,178,85,0.72');

// ─── EFFECT STATE ────────────────────────────────────────────────────────────

function randomBetween(min, max) {
	return min + Math.random() * (max - min);
}

function spawnMote() {
	return {
		x:      randomBetween(CONFIG.originXMin,   CONFIG.originXMax  ) * window.innerWidth,
		y:      randomBetween(CONFIG.originYMin,   CONFIG.originYMax  ) * window.innerHeight,
		vy:     randomBetween(CONFIG.riseSpeedMin, CONFIG.riseSpeedMax),
		vx:     randomBetween(CONFIG.driftXMin,    CONFIG.driftXMax   ),
		alpha:  randomBetween(CONFIG.alphaMin,     CONFIG.alphaMax    ),
		radius: randomBetween(CONFIG.radiusMin,    CONFIG.radiusMax   ),
		phase:  Math.random() * Math.PI * 2,
		freq:   CONFIG.wobbleFreq * randomBetween(0.7, 1.3)
	};
}

const motes = Array.from({length: CONFIG.moteCount}, spawnMote);

// ─── DRAW ────────────────────────────────────────────────────────────────────

function drawMote(m) {
	const glowR = m.radius * CONFIG.glowRadiusMultiplier;
	const glow  = ctx.createRadialGradient(m.x, m.y, 0, m.x, m.y, glowR);

	glow.addColorStop(0, withAlpha(colour, m.alpha * CONFIG.glowAlphaFraction));
	glow.addColorStop(1, withAlpha(colour, 0));

	ctx.beginPath();
	ctx.arc(m.x, m.y, glowR, 0, Math.PI * 2);
	ctx.fillStyle = glow;
	ctx.fill();

	ctx.beginPath();
	ctx.arc(m.x, m.y, m.radius, 0, Math.PI * 2);
	ctx.fillStyle = withAlpha(colour, m.alpha);
	ctx.fill();
}

function draw(t) {
	const W       = window.innerWidth;
	const beamMin = CONFIG.originXMin * W;
	const beamMax = CONFIG.originXMax * W;

	ctx.clearRect(0, 0, W, window.innerHeight);

	for (const m of motes) {
		m.y += m.vy;
		m.x += m.vx + Math.sin(t * m.freq * 60 + m.phase) * CONFIG.wobbleAmp;

		if (m.x < beamMin || m.x > beamMax) {
			m.alpha = Math.max(0, m.alpha - CONFIG.fadeRate);
		}

		if (m.alpha <= 0 || m.y < -10) {
			Object.assign(m, spawnMote());
		}

		drawMote(m);
	}
}

// ─── REDUCED MOTION — skip drawing entirely ──────────────────────────────────

if (reducedMotion) {
	createCleanup(canvas, rafRef, resize);
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
	let t = 0;

	function tick() {
		draw(t);
		t += 0.016;
		rafRef.current = requestAnimationFrame(tick);
	}

	rafRef.current = requestAnimationFrame(tick);
	createCleanup(canvas, rafRef, resize);
}
