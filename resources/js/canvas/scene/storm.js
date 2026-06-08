/**
 * Storm — rainfall and splash canvas effect.
 *
 * Used by Chapter 003 (mood-storm). Rain drops fall at an angle with wind,
 * layered front-to-back for depth, and produce ring + particle splashes
 * where they hit the bottom of the viewport. Each layer's near/far depth
 * scales drop length, speed, alpha, and stroke width, so the rain reads
 * as volumetric rather than a flat curtain.
 *
 * The rain hue is the storm-mood palette's ink-accent token — the same
 * cool greenish-grey that the rest of the chapter is built from, so the
 * rain integrates with the page tonality instead of sitting on top of
 * it as a separate weather layer.
 *
 * Canvas class  : x3p0-canvas-scene--storm
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized but not drawn
 *
 * @file resources/js/canvas/scene/storm.js
 */

import {setupCanvas, extractColour, withAlpha, createCleanup} from 'x3p0/canvas-utils';

const canvas = document.querySelector('.x3p0-canvas-scene--storm');

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// Number of rain drops on screen at once.
	count: 320,

	// Horizontal wind strength (px/frame at full depth).
	windX: 3.5,

	// Global fall speed knob. Combined with per-drop dropSpeedMin/Max and
	// speedReference below to produce final velocity per drop.
	speed: 25,

	// Calibration: value of `speed` at which the speed multiplier equals 1.
	// Higher `speed` makes everything fall faster; lower slows it.
	speedReference: 15,

	// Overall canvas opacity (0–1) — applied as ctx.globalAlpha for the frame.
	opacity: 0.85,

	// Drop length range (px). Scaled per drop by its depth factor.
	dropLenMin: 8,
	dropLenMax: 18,

	// Drop speed range (px/frame, pre-multiplier). Scaled per drop by depth.
	dropSpeedMin: 6,
	dropSpeedMax: 10,

	// Drop alpha range. Scaled per drop by depth. Kept high because the storm
	// background is near-black — these multiply against the token's own alpha
	// and the frame opacity, so anything lower reads as invisible.
	dropAlphaMin: 0.32,
	dropAlphaMax: 0.68,

	// Drop stroke width range (px). Scaled per drop by depth. The minimum is
	// held above ~0.8 so the thinnest far drops do not antialias away on HiDPI.
	dropWidthMin: 0.9,
	dropWidthMax: 1.5,

	// Splash ring alpha range. Scaled per drop by depth.
	splashAlphaMin: 0.28,
	splashAlphaMax: 0.42,

	// Splash ring radius range (px). Scaled per drop by depth.
	splashRadiusMin: 2,
	splashRadiusMax: 4,

	// Splash ring stroke width (px).
	splashStrokeWidth: 0.8,

	// Splash ring grows over its life — this is the additional fraction by
	// which it expands from birth to death (0 = no growth, 1 = doubles).
	splashRingGrowth: 0.6,

	// Splash particle count range per splash.
	splashPartsMin: 5,
	splashPartsMax: 8,

	// Splash particle launch speed range (px/frame).
	splashSpeedMin: 1,
	splashSpeedMax: 2,

	// Initial upward kick on every splash particle's vy (px/frame).
	splashLaunchY: -2.5,

	// Splash particle gravity per frame (px/frame²).
	splashGravity: 0.22,

	// Drawn radius of each splash particle (px).
	splashPartRadius: 1,

	// Splash life decay per frame (fraction of full life).
	splashDecay: 0.055
};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

(() => {
	const map = {
		count:             Number,
		windX:             Number,
		speed:             Number,
		speedReference:    Number,
		opacity:           Number,
		dropLenMin:        Number,
		dropLenMax:        Number,
		dropSpeedMin:      Number,
		dropSpeedMax:      Number,
		dropAlphaMin:      Number,
		dropAlphaMax:      Number,
		dropWidthMin:      Number,
		dropWidthMax:      Number,
		splashAlphaMin:    Number,
		splashAlphaMax:    Number,
		splashRadiusMin:   Number,
		splashRadiusMax:   Number,
		splashStrokeWidth: Number,
		splashRingGrowth:  Number,
		splashPartsMin:    Number,
		splashPartsMax:    Number,
		splashSpeedMin:    Number,
		splashSpeedMax:    Number,
		splashLaunchY:     Number,
		splashGravity:     Number,
		splashPartRadius:  Number,
		splashDecay:       Number
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

// Storm-mood ink-accent is a cool greenish-grey at alpha 0.70. The token's
// alpha is preserved through withAlpha() so the rain stays as subtle as the
// designer intended.
let colour = extractColour(canvas, '--wp--preset--color--ink-accent', '160,200,160,0.70');

function rainColour(alpha) {
	return withAlpha(colour, alpha);
}

// ─── EFFECT STATE ────────────────────────────────────────────────────────────

function randomBetween(min, max) {
	return min + Math.random() * (max - min);
}

function mkDrop() {
	const W     = window.innerWidth;
	const H     = window.innerHeight;
	const layer = Math.random();           // 0 = far/dim, 1 = near/bright
	const depth = 0.4 + layer * 0.9;       // per-drop depth scalar

	return {
		x:     Math.random() * W * 1.5 - W * 0.25,
		y:     -Math.random() * H,
		len:   randomBetween(CONFIG.dropLenMin,   CONFIG.dropLenMax  ) * depth,
		speed: randomBetween(CONFIG.dropSpeedMin, CONFIG.dropSpeedMax) * depth,
		alpha: CONFIG.dropAlphaMin + layer * CONFIG.dropAlphaMax,
		width: CONFIG.dropWidthMin + layer * CONFIG.dropWidthMax,
		layer
	};
}

function spawnSplash(x, y, layer) {
	const count = CONFIG.splashPartsMin + Math.floor(Math.random() * (CONFIG.splashPartsMax - CONFIG.splashPartsMin));
	const parts = [];

	for (let i = 0; i < count; i++) {
		const angle = -Math.PI + Math.random() * Math.PI;
		const speed = randomBetween(CONFIG.splashSpeedMin, CONFIG.splashSpeedMax);

		parts.push({
			x,
			y,
			vx: Math.cos(angle) * speed,
			vy: Math.sin(angle) * speed + CONFIG.splashLaunchY
		});
	}

	splashes.push({
		x,
		y,
		r:     randomBetween(CONFIG.splashRadiusMin, CONFIG.splashRadiusMax) * (0.4 + layer * 0.8),
		parts,
		life:  1,
		alpha: CONFIG.splashAlphaMin + layer * CONFIG.splashAlphaMax
	});
}

const drops    = Array.from({length: CONFIG.count}, () => {
	const d = mkDrop();
	d.y     = Math.random() * window.innerHeight;
	return d;
});

const splashes = [];

// ─── DRAW ────────────────────────────────────────────────────────────────────

function draw() {
	const W         = window.innerWidth;
	const H         = window.innerHeight;
	const speedMult = CONFIG.speed / CONFIG.speedReference;

	ctx.clearRect(0, 0, W, H);
	ctx.globalAlpha = CONFIG.opacity;

	for (let i = 0; i < drops.length; i++) {
		const d  = drops[i];
		const vx = CONFIG.windX * (0.3 + d.layer * 0.9) * speedMult;
		const vy = d.speed * speedMult;

		d.x += vx;
		d.y += vy;

		const tx   = d.x - (vx / vy) * d.len;
		const ty   = d.y - d.len;
		const grad = ctx.createLinearGradient(tx, ty, d.x, d.y);

		grad.addColorStop(0, rainColour(0));
		grad.addColorStop(1, rainColour(d.alpha));

		ctx.beginPath();
		ctx.moveTo(tx, ty);
		ctx.lineTo(d.x, d.y);
		ctx.strokeStyle = grad;
		ctx.lineWidth   = d.width;
		ctx.stroke();

		if (d.y > H + d.len) {
			spawnSplash(d.x, H, d.layer);
			drops[i] = mkDrop();
		} else if (d.x > W * 1.3 || d.x < -W * 0.3) {
			drops[i] = mkDrop();
		}
	}

	for (let si = splashes.length - 1; si >= 0; si--) {
		const sp = splashes[si];
		sp.life -= CONFIG.splashDecay;

		if (sp.life <= 0) {
			splashes.splice(si, 1);
			continue;
		}

		ctx.beginPath();
		ctx.arc(sp.x, sp.y, sp.r * (1 + (1 - sp.life) * CONFIG.splashRingGrowth), 0, Math.PI * 2);
		ctx.strokeStyle = rainColour(sp.alpha * sp.life);
		ctx.lineWidth   = CONFIG.splashStrokeWidth;
		ctx.stroke();

		for (const p of sp.parts) {
			p.x  += p.vx;
			p.y  += p.vy;
			p.vy += CONFIG.splashGravity;

			if (p.y < H) {
				ctx.beginPath();
				ctx.arc(p.x, p.y, CONFIG.splashPartRadius, 0, Math.PI * 2);
				ctx.fillStyle = rainColour(sp.alpha * sp.life * 0.5);
				ctx.fill();
			}
		}
	}

	ctx.globalAlpha = 1;
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
