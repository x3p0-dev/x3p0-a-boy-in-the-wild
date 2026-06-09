/**
 * Smoke — the last thread of a dead fire, rising and drifting apart.
 *
 * A thin, faint column of smoke lifts from the bottom-left of the page,
 * leans slowly to the right as it climbs, wavers, widens, and thins to
 * nothing. Built for Chapter 7 (midwinter), tied to the opening line — "The
 * fire from their camp is gone." What is left is only the trace: the warmth
 * and the people gone, the smoke dissipating after them. It is drawn in the
 * palette's foreground ink at a low opacity so it reads as a pale wisp
 * against the dark page without ever competing with the prose.
 *
 * Canvas class  : x3p0-canvas-scene--smoke
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: nothing is drawn — a frozen wisp is meaningless, so the
 *                 scene is simply still
 *
 * @file resources/js/canvas/scene/smoke.js
 */

import {setupCanvas, extractColour, withAlpha, createCleanup} from 'x3p0/canvas-utils';

const canvas = document.querySelector('.x3p0-canvas-scene--smoke');

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// Where the smoke lifts from, as fractions of the viewport. Bottom-left,
	// just in from the corner — the spot where their fire was.
	originX: 0.10,
	originY: 1.0,

	// Random scatter of the source per particle, as fractions of the
	// viewport, so the base of the column is soft rather than a fixed point.
	originJitterX: 0.015,
	originJitterY: 0.010,

	// Smoke particles emitted per second. Higher = a denser thread.
	emitRate: 4,

	// How long a particle lives, from the source to fully dissipated. (s)
	life: 10,

	// Per-particle variance on lifespan, as a fraction.
	lifeVariance: 0.30,

	// Upward drift of the smoke. (px per second)
	rise: 40,

	// Per-particle variance on the rise, as a fraction.
	riseVariance: 0.30,

	// Rightward lean of the smoke as it climbs. (px per second)
	drift: 30,

	// Per-particle variance on the drift, as a fraction.
	driftVariance: 0.30,

	// Lateral sway as the column rises — the waver of smoke in still air.
	curlAmp: 13,    // amplitude (px per second)
	curlFreq: 0.8,  // how quickly the sway oscillates (radians per second)

	// Particle radius across its life — smoke diffuses wider as it rises. (px)
	radiusStart: 18,
	radiusEnd: 118,

	// Fraction of life spent fading in at the source. The remainder fades out
	// linearly toward the top, so the thread is densest low and thins as it
	// dissipates.
	fadeIn: 0.12,

	// Peak opacity of a single particle, applied on top of the token's own
	// alpha. Kept low so the smoke stays a faint trace.
	alphaPeak: 0.09
};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

(() => {
	const map = {
		originX:       Number,
		originY:       Number,
		originJitterX: Number,
		originJitterY: Number,
		emitRate:      Number,
		life:          Number,
		lifeVariance:  Number,
		rise:          Number,
		riseVariance:  Number,
		drift:         Number,
		driftVariance: Number,
		curlAmp:       Number,
		curlFreq:      Number,
		radiusStart:   Number,
		radiusEnd:     Number,
		fadeIn:        Number,
		alphaPeak:     Number
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

// The foreground ink — a pale, warm off-white in the midwinter palette. As a
// foreground colour it always carries enough contrast against the page to
// read as smoke. Its own alpha is honoured through withAlpha(); alphaPeak
// multiplies on top of it.
let tone = extractColour(canvas, '--wp--preset--color--ink', '188,184,165,0.80');

// ─── EFFECT STATE ────────────────────────────────────────────────────────────

const particles = [];

// Fractional carry for the emitter, so a non-integer rate stays frame-rate
// independent.
let emitCarry = 0;

let last = null;

function clamp01(value) {
	return Math.max(0, Math.min(1, value));
}

// Spawn one particle. An initial age > 0 seeds it mid-flight, used to prewarm
// the column so smoke is already present on load rather than starting bare.
function spawn(initialAge = 0) {
	const W = window.innerWidth;
	const H = window.innerHeight;

	const ox    = (CONFIG.originX + (Math.random() * 2 - 1) * CONFIG.originJitterX) * W;
	const oy    = (CONFIG.originY + (Math.random() * 2 - 1) * CONFIG.originJitterY) * H;
	const rise  = CONFIG.rise  * (1 + (Math.random() * 2 - 1) * CONFIG.riseVariance);
	const drift = CONFIG.drift * (1 + (Math.random() * 2 - 1) * CONFIG.driftVariance);
	const life  = CONFIG.life  * (1 + (Math.random() * 2 - 1) * CONFIG.lifeVariance);

	particles.push({
		x:     ox + drift * initialAge,
		y:     oy - rise * initialAge,
		age:   initialAge,
		life:  life,
		rise:  rise,
		drift: drift,
		phase: Math.random() * Math.PI * 2
	});
}

// ─── DRAW ────────────────────────────────────────────────────────────────────

function draw() {
	ctx.clearRect(0, 0, window.innerWidth, window.innerHeight);

	for (const p of particles) {
		const t = clamp01(p.age / p.life);

		const fade  = clamp01(t / CONFIG.fadeIn) * (1 - t);
		const alpha = CONFIG.alphaPeak * fade;

		if (alpha <= 0) {
			continue;
		}

		const radius = CONFIG.radiusStart + (CONFIG.radiusEnd - CONFIG.radiusStart) * t;

		const grad = ctx.createRadialGradient(p.x, p.y, 0, p.x, p.y, radius);
		grad.addColorStop(0, withAlpha(tone, alpha));
		grad.addColorStop(1, withAlpha(tone, 0));

		ctx.fillStyle = grad;
		ctx.fillRect(p.x - radius, p.y - radius, radius * 2, radius * 2);
	}
}

// ─── REDUCED MOTION — draw nothing, the scene is still ───────────────────────

if (reducedMotion) {
	draw();
	createCleanup(canvas, rafRef, resize);
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
	// Prewarm the column so the thread is already rising on load.
	const seed = Math.round(CONFIG.emitRate * CONFIG.life);

	for (let i = 0; i < seed; i++) {
		spawn(Math.random() * CONFIG.life);
	}

	function tick(timestamp) {
		const dt = last === null ? 0 : (timestamp - last) / 1000;
		last = timestamp;

		emitCarry += CONFIG.emitRate * dt;

		while (emitCarry >= 1) {
			spawn();
			emitCarry -= 1;
		}

		for (let i = particles.length - 1; i >= 0; i--) {
			const p = particles[i];
			p.age += dt;

			if (p.age >= p.life) {
				particles.splice(i, 1);
				continue;
			}

			const curl = Math.sin(p.age * CONFIG.curlFreq + p.phase) * CONFIG.curlAmp;

			p.x += (p.drift + curl) * dt;
			p.y += -p.rise * dt;
		}

		draw();
		rafRef.current = requestAnimationFrame(tick);
	}

	rafRef.current = requestAnimationFrame(tick);
	createCleanup(canvas, rafRef, resize);
}
