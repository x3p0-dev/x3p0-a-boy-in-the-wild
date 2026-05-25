/**
 * Snow and embers — atmospheric canvas effect.
 *
 * Intended for Chapter 5 ("How to Make a Fire When Everything Is Wet") with
 * the mood-campfire style variation. Snow falls from above (pure white,
 * subtle alpha); embers rise from a fixed origin point in the lower-right
 * area of the canvas (the chapter's warm ink-accent). Two particle pools,
 * one canvas. Particle sizes scale with viewport area against a 1440×900
 * reference so the effect looks proportionally consistent at any size.
 *
 * Colour tokens:
 *   `--white`       — pure white for snow flakes
 *   `--ink-accent`  — warm orange for ember glow + core (mood-campfire's
 *                     ink-accent is `rgba(200,140,60,0.80)`, exactly the
 *                     ember hue this effect wants)
 *
 * Canvas class  : x3p0-canvas-scene--snow-embers
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized but not drawn (mid-flight particles
 *                 would read as a frozen-stamped scene, not a still moment)
 *
 * @file resources/js/canvas/scene/snow-embers.js
 */

import {setupCanvas, extractColour, withAlpha, createCleanup} from 'x3p0/canvas-utils';

const canvas = document.querySelector('.x3p0-canvas-scene--snow-embers');

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// ── Snow ─────────────────────────────────────────────────────────────────

	// Number of snow particles on screen at once.
	snowCount: 60,

	// Snow flake radius range (px, before viewport-area scale).
	snowRadiusMin: 0.4,
	snowRadiusMax: 1.8,

	// Snow fall speed range (px/frame).
	snowSpeedMin: 0.15,
	snowSpeedMax: 0.55,

	// Snow horizontal drift range — base linear sideways motion (px/frame).
	snowDriftRange: 0.3,

	// Per-flake alpha range (multiplied by the white token's alpha).
	snowOpacityMin: 0.08,
	snowOpacityMax: 0.41,

	// Snow flicker — small sinusoidal variation added/subtracted from alpha.
	snowFlickerAmp:   0.06,
	snowFlickerSpeed: 0.04,    // radians/frame

	// Snow lateral oscillation — independent sinusoidal x wander.
	snowOscSpeed: 0.008,       // radians/frame
	snowOscAmp:   0.15,        // px

	// How far past the viewport edge a flake travels before recycling.
	snowSpawnMargin: 10,

	// ── Embers ───────────────────────────────────────────────────────────────

	// Number of ember particles on screen at once.
	emberCount: 18,

	// Ember origin as fractions of viewport size — lower-right by default.
	emberOriginX: 0.84,
	emberOriginY: 0.84,

	// Spawn scatter around the origin (px).
	emberScatterX: 80,
	emberScatterY: 40,

	// Ember core radius range (px, before viewport-area scale).
	emberRadiusMin: 0.6,
	emberRadiusMax: 2.4,

	// Glow halo radius added on top of the core radius (px, before scale).
	emberGlowRadius: 1.5,

	// Glow alpha as a fraction of the ember's current alpha.
	emberGlowAlphaFactor: 0.5,

	// Ember rise speed range (px/frame).
	emberSpeedMin: 0.2,
	emberSpeedMax: 0.7,

	// Ember horizontal drift range — base linear sideways motion (px/frame).
	emberDriftRange: 0.4,

	// Per-ember alpha range (multiplied by the ink-accent token's alpha).
	emberOpacityMin: 0.15,
	emberOpacityMax: 0.60,

	// Ember alpha fade per frame — embers gradually dim as they rise.
	emberFade: 0.0008,

	// Ember flicker — sinusoidal variation added to alpha each frame.
	emberFlickerAmp: 0.08,

	// Ember lateral oscillation — independent sinusoidal x wander.
	emberOscSpeed: 0.015,      // radians/frame
	emberOscAmp:   0.3,        // px

	// How far past the top edge an ember rises before recycling.
	emberRecycleMargin: 10,

	// ── Viewport-area scaling ───────────────────────────────────────────────

	// Auto: particle sizes scale by √(area / refArea). Override `scale`
	// via data attribute to lock it (auto switches off automatically).
	scaleAuto:      true,
	scale:          1,
	scaleMin:       0.4,
	scaleMax:       2.5,
	scaleRefWidth:  1440,
	scaleRefHeight: 900
};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

(() => {
	const map = {
		snowCount:            Number,
		snowRadiusMin:        Number,
		snowRadiusMax:        Number,
		snowSpeedMin:         Number,
		snowSpeedMax:         Number,
		snowDriftRange:       Number,
		snowOpacityMin:       Number,
		snowOpacityMax:       Number,
		snowFlickerAmp:       Number,
		snowFlickerSpeed:     Number,
		snowOscSpeed:         Number,
		snowOscAmp:           Number,
		snowSpawnMargin:      Number,
		emberCount:           Number,
		emberOriginX:         Number,
		emberOriginY:         Number,
		emberScatterX:        Number,
		emberScatterY:        Number,
		emberRadiusMin:       Number,
		emberRadiusMax:       Number,
		emberGlowRadius:      Number,
		emberGlowAlphaFactor: Number,
		emberSpeedMin:        Number,
		emberSpeedMax:        Number,
		emberDriftRange:      Number,
		emberOpacityMin:      Number,
		emberOpacityMax:      Number,
		emberFade:            Number,
		emberFlickerAmp:      Number,
		emberOscSpeed:        Number,
		emberOscAmp:          Number,
		emberRecycleMargin:   Number,
		scale:                Number,
		scaleMin:             Number,
		scaleMax:             Number,
		scaleRefWidth:        Number,
		scaleRefHeight:       Number
	};

	Object.keys(map).forEach((key) => {
		if (canvas.dataset[key] !== undefined) {
			CONFIG[key] = map[key](canvas.dataset[key]);

			// If scale is explicitly set, switch off auto.
			if (key === 'scale') CONFIG.scaleAuto = false;
		}
	});
})();

// ─── CANVAS SETUP ────────────────────────────────────────────────────────────

const rafRef = {current: null};

const {ctx, resize} = setupCanvas(canvas);

// ─── REDUCED MOTION ──────────────────────────────────────────────────────────

const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

// ─── COLOUR ──────────────────────────────────────────────────────────────────

let snowColour  = extractColour(canvas, '--wp--preset--color--white',      '255,255,255'    );
let emberColour = extractColour(canvas, '--wp--preset--color--ink-accent', '200,140,60,0.80');

// ─── EFFECT STATE ────────────────────────────────────────────────────────────

function randomBetween(min, max) {
	return min + Math.random() * (max - min);
}

function getScale() {
	if (! CONFIG.scaleAuto) return CONFIG.scale;

	const ratio = Math.sqrt(
		(window.innerWidth * window.innerHeight) /
		(CONFIG.scaleRefWidth * CONFIG.scaleRefHeight)
	);

	return Math.max(CONFIG.scaleMin, Math.min(CONFIG.scaleMax, ratio));
}

function emberOrigin() {
	return {
		x: window.innerWidth  * CONFIG.emberOriginX,
		y: window.innerHeight * CONFIG.emberOriginY
	};
}

function spawnSnow() {
	return {
		x:       Math.random() * window.innerWidth,
		y:       Math.random() * window.innerHeight,
		r:       randomBetween(CONFIG.snowRadiusMin,  CONFIG.snowRadiusMax ),
		speed:   randomBetween(CONFIG.snowSpeedMin,   CONFIG.snowSpeedMax  ),
		drift:   (Math.random() - 0.5) * CONFIG.snowDriftRange,
		opacity: randomBetween(CONFIG.snowOpacityMin, CONFIG.snowOpacityMax),
		phase:   Math.random() * Math.PI * 2
	};
}

function spawnEmber() {
	const o = emberOrigin();
	return {
		x:       o.x + (Math.random() - 0.5) * CONFIG.emberScatterX,
		y:       o.y + Math.random() * CONFIG.emberScatterY,
		r:       randomBetween(CONFIG.emberRadiusMin,  CONFIG.emberRadiusMax ),
		speed:   randomBetween(CONFIG.emberSpeedMin,   CONFIG.emberSpeedMax  ),
		drift:   (Math.random() - 0.5) * CONFIG.emberDriftRange,
		opacity: randomBetween(CONFIG.emberOpacityMin, CONFIG.emberOpacityMax),
		phase:   Math.random() * Math.PI * 2
	};
}

const snow   = Array.from({length: CONFIG.snowCount },  spawnSnow);
const embers = Array.from({length: CONFIG.emberCount}, spawnEmber);

// ─── DRAW ────────────────────────────────────────────────────────────────────

function draw(frame) {
	const scale = getScale();
	const W     = window.innerWidth;
	const H     = window.innerHeight;
	const SM    = CONFIG.snowSpawnMargin;
	const EM    = CONFIG.emberRecycleMargin;

	ctx.clearRect(0, 0, W, H);

	// ── Snow ─────────────────────────────────────────────────────────────────
	for (const s of snow) {
		s.y += s.speed;
		s.x += s.drift + Math.sin(frame * CONFIG.snowOscSpeed + s.phase) * CONFIG.snowOscAmp;

		if (s.y > H + SM) { s.y = -SM;    s.x = Math.random() * W; }
		if (s.x < -SM   ) { s.x = W + SM; }
		if (s.x > W + SM) { s.x = -SM;    }

		const flicker = Math.sin(frame * CONFIG.snowFlickerSpeed + s.phase) * CONFIG.snowFlickerAmp;

		ctx.beginPath();
		ctx.arc(s.x, s.y, s.r * scale, 0, Math.PI * 2);
		ctx.fillStyle = withAlpha(snowColour, s.opacity + flicker);
		ctx.fill();
	}

	// ── Embers ───────────────────────────────────────────────────────────────
	for (const e of embers) {
		e.y       -= e.speed;
		e.x       += e.drift + Math.sin(frame * CONFIG.emberOscSpeed + e.phase) * CONFIG.emberOscAmp;
		e.opacity -= CONFIG.emberFade;

		if (e.y < -EM || e.opacity <= 0) {
			Object.assign(e, spawnEmber());
		}

		const flicker = Math.sin(frame * CONFIG.emberOscSpeed + e.phase) * CONFIG.emberFlickerAmp;

		// Glow halo — larger, softer
		ctx.beginPath();
		ctx.arc(e.x, e.y, (e.r + CONFIG.emberGlowRadius) * scale, 0, Math.PI * 2);
		ctx.fillStyle = withAlpha(emberColour, e.opacity * CONFIG.emberGlowAlphaFactor);
		ctx.fill();

		// Core
		ctx.beginPath();
		ctx.arc(e.x, e.y, e.r * scale, 0, Math.PI * 2);
		ctx.fillStyle = withAlpha(emberColour, e.opacity + flicker);
		ctx.fill();
	}
}

// ─── REDUCED MOTION — skip drawing entirely ──────────────────────────────────

if (reducedMotion) {
	createCleanup(canvas, rafRef, resize);
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
	let frame = 0;

	function tick() {
		draw(frame);
		frame++;
		rafRef.current = requestAnimationFrame(tick);
	}

	rafRef.current = requestAnimationFrame(tick);
	createCleanup(canvas, rafRef, resize);
}
