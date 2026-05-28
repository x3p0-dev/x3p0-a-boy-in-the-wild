/**
 * Snowfall — snow drifts down and slowly accumulates at the bottom of the
 * viewport.
 *
 * Flake rendering follows the snow particle approach from `snow-embers.js`:
 * a simple low-alpha arc per flake, with subtle per-frame flicker and
 * sinusoidal lateral oscillation layered over a linear drift. Particle
 * size scales with viewport area so the field reads proportionally
 * consistent at any screen size. No glow, no halo — snow at any reading
 * distance reads as faint specks, not luminous puffs.
 *
 * When a flake reaches the pile, it's absorbed: a height-map column grows
 * by a small amount, with diffusion to its neighbours. A very slow per-
 * frame smoothing pass averages each column with its neighbours so the
 * pile reads as a soft drift rather than a row of spikes. Pile height is
 * capped per-column at a configurable fraction of viewport height — once
 * a column is full, further flakes land there visually but the pile stops
 * growing.
 *
 * The pile fills with a vertical gradient that is softer at the top edge
 * and fully opaque at the floor, so the contour reads as snow settling
 * rather than a hard cut-out shape.
 *
 * Canvas class  : x3p0-canvas-scene--snowfall
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: a static pile at a moderate height is drawn once, with
 *                 light per-column jitter so it doesn't read as a ribbon.
 *                 No flakes fall.
 *
 * @file resources/js/canvas/scene/snowfall.js
 */

import {setupCanvas, extractColour, withAlpha, createCleanup} from 'x3p0/canvas-utils';

const canvas = document.querySelector('.x3p0-canvas-scene--snowfall');

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// ── Flakes ───────────────────────────────────────────────────────────────

	// Number of falling flakes on screen at once.
	flakeCount: 55,

	// Flake radius range (px, before viewport-area scale).
	flakeRadiusMin: 0.4,
	flakeRadiusMax: 1.8,

	// Fall speed range (px/frame).
	flakeSpeedMin: 0.15,
	flakeSpeedMax: 0.55,

	// Horizontal drift range — each flake picks a base linear sideways
	// motion in [-driftRange/2, driftRange/2] (px/frame).
	driftRange: 0.3,

	// Per-flake alpha range (multiplied by the token's alpha). Kept low —
	// snow at any reading distance reads as faint.
	alphaMin: 0.08,
	alphaMax: 0.41,

	// Flicker — small sinusoidal variation added to or subtracted from
	// each flake's alpha per frame, so the field breathes slightly.
	flickerAmp:   0.06,
	flickerSpeed: 0.04,    // radians/frame

	// Lateral oscillation — sinusoidal x wander, independent of drift.
	oscSpeed: 0.008,       // radians/frame
	oscAmp:   0.15,        // px

	// How far above the viewport edge a flake respawns (px).
	spawnMargin: 10,

	// ── Pile ─────────────────────────────────────────────────────────────────

	// Number of pile columns spanning the viewport width. More columns = a
	// smoother pile contour but slightly more work per frame.
	pileColumns: 200,

	// Maximum pile height per column, as a fraction of viewport height.
	pileMaxFraction: 0.18,

	// Pile contribution per landed flake (px added to the column it lands on).
	pileGain: 1.4,

	// Fraction of pileGain added to the two columns flanking the landing
	// column. Diffusing each landing across three columns prevents the pile
	// from forming sharp spikes under heavily-trafficked x positions.
	pileNeighbourGain: 0.5,

	// Per-frame smoothing — fraction by which each column is averaged toward
	// the mean of itself and its neighbours. Very small; the pile should
	// settle gradually so the texture stays alive while it builds.
	pileSmoothing: 0.003,

	// Pile fill alpha (multiplied by the token's alpha). Slightly under 1 at
	// the top edge so the contour reads as snow against the page background.
	pileAlphaTop:    0.78,
	pileAlphaBottom: 0.96,

	// Dirt blend — strength of the parchment background colour mixed into
	// the pile bottom (0–1). 0 = pure white pile; 1 = bottom edge is the
	// parchment colour itself. Reads `--wp--preset--color--parchment` so
	// the dirty tone matches each chapter's page background.
	pileDirtBlend: 0.45,

	// Where the dirt blend begins, as a fraction of the gradient height.
	// Above this point the pile is clean white; below it the parchment
	// tint phases in toward the floor.
	pileDirtStart: 0.55,

	// Reduced-motion static pile height, as a fraction of pileMaxFraction.
	reducedMotionFraction: 0.45,

	// Reduced-motion per-column jitter, as a fraction of the static height.
	reducedMotionJitter: 0.06,

	// ── Viewport-area scaling ────────────────────────────────────────────────

	// Auto: particle sizes scale by √(area / refArea). Override `scale` via
	// data attribute to lock it (auto switches off automatically).
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
		flakeCount:            Number,
		flakeRadiusMin:        Number,
		flakeRadiusMax:        Number,
		flakeSpeedMin:         Number,
		flakeSpeedMax:         Number,
		driftRange:            Number,
		alphaMin:              Number,
		alphaMax:              Number,
		flickerAmp:            Number,
		flickerSpeed:          Number,
		oscSpeed:              Number,
		oscAmp:                Number,
		spawnMargin:           Number,
		pileColumns:           Number,
		pileMaxFraction:       Number,
		pileGain:              Number,
		pileNeighbourGain:     Number,
		pileSmoothing:         Number,
		pileAlphaTop:          Number,
		pileAlphaBottom:       Number,
		pileDirtBlend:         Number,
		pileDirtStart:         Number,
		reducedMotionFraction: Number,
		reducedMotionJitter:   Number,
		scale:                 Number,
		scaleMin:              Number,
		scaleMax:              Number,
		scaleRefWidth:         Number,
		scaleRefHeight:        Number
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

// Snow colour anchors the flakes and the pile top. Parchment is the page
// background — typically dark in the winter moods (mid-winter is #242820)
// — and is blended into the pile bottom to suggest snow contaminated by
// the ground beneath it.
let snowColour = extractColour(canvas, '--wp--preset--color--white',     '255,255,255');
let dirtColour = extractColour(canvas, '--wp--preset--color--parchment', '36,40,32');

function blendColours(c1, c2, t) {
	const [r1, g1, b1] = c1.rgb.split(',').map(Number);
	const [r2, g2, b2] = c2.rgb.split(',').map(Number);
	return {
		rgb:   `${(r1 + (r2 - r1) * t).toFixed(1)},${(g1 + (g2 - g1) * t).toFixed(1)},${(b1 + (b2 - b1) * t).toFixed(1)}`,
		alpha: c1.alpha + (c2.alpha - c1.alpha) * t
	};
}

let muddyColour = blendColours(snowColour, dirtColour, CONFIG.pileDirtBlend);

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

const pileHeights = new Array(CONFIG.pileColumns).fill(0);

function columnAt(x) {
	const ratio = x / window.innerWidth;
	return Math.min(
		CONFIG.pileColumns - 1,
		Math.max(0, Math.floor(ratio * CONFIG.pileColumns))
	);
}

function pileHeightAt(x) {
	return pileHeights[columnAt(x)];
}

function addToPile(x) {
	const col       = columnAt(x);
	const maxHeight = window.innerHeight * CONFIG.pileMaxFraction;

	pileHeights[col] = Math.min(maxHeight, pileHeights[col] + CONFIG.pileGain);

	if (col > 0) {
		pileHeights[col - 1] = Math.min(
			maxHeight,
			pileHeights[col - 1] + CONFIG.pileNeighbourGain
		);
	}
	if (col < CONFIG.pileColumns - 1) {
		pileHeights[col + 1] = Math.min(
			maxHeight,
			pileHeights[col + 1] + CONFIG.pileNeighbourGain
		);
	}
}

function smoothPile() {
	if (CONFIG.pileSmoothing <= 0) return;

	const next = new Array(CONFIG.pileColumns);
	const f    = CONFIG.pileSmoothing;
	const n    = CONFIG.pileColumns;

	for (let col = 0; col < n; col++) {
		const left  = col > 0     ? pileHeights[col - 1] : pileHeights[col];
		const right = col < n - 1 ? pileHeights[col + 1] : pileHeights[col];
		const avg   = (left + pileHeights[col] + right) / 3;
		next[col]   = pileHeights[col] * (1 - f) + avg * f;
	}

	for (let col = 0; col < n; col++) {
		pileHeights[col] = next[col];
	}
}

function spawnFlake(spawnAcross) {
	return {
		x:       Math.random() * window.innerWidth,
		y:       spawnAcross
			? Math.random() * window.innerHeight
			: -CONFIG.spawnMargin - Math.random() * CONFIG.spawnMargin,
		r:       randomBetween(CONFIG.flakeRadiusMin, CONFIG.flakeRadiusMax),
		speed:   randomBetween(CONFIG.flakeSpeedMin,  CONFIG.flakeSpeedMax ),
		drift:   (Math.random() - 0.5) * CONFIG.driftRange,
		opacity: randomBetween(CONFIG.alphaMin,       CONFIG.alphaMax      ),
		phase:   Math.random() * Math.PI * 2
	};
}

const flakes = Array.from({length: CONFIG.flakeCount}, () => spawnFlake(true));

// ─── DRAW ────────────────────────────────────────────────────────────────────

function drawFlake(f, frame, scale) {
	const flicker = Math.sin(frame * CONFIG.flickerSpeed + f.phase) * CONFIG.flickerAmp;

	ctx.beginPath();
	ctx.arc(f.x, f.y, f.r * scale, 0, Math.PI * 2);
	ctx.fillStyle = withAlpha(snowColour, f.opacity + flicker);
	ctx.fill();
}

function drawPile() {
	const W    = window.innerWidth;
	const H    = window.innerHeight;
	const maxH = H * CONFIG.pileMaxFraction;
	const n    = CONFIG.pileColumns;

	const grad = ctx.createLinearGradient(0, H - maxH, 0, H);
	grad.addColorStop(0,                    withAlpha(snowColour,  CONFIG.pileAlphaTop   ));
	grad.addColorStop(CONFIG.pileDirtStart, withAlpha(snowColour,  CONFIG.pileAlphaTop   ));
	grad.addColorStop(1,                    withAlpha(muddyColour, CONFIG.pileAlphaBottom));

	ctx.beginPath();
	ctx.moveTo(0, H);

	for (let col = 0; col < n; col++) {
		const x = (col / (n - 1)) * W;
		const y = H - pileHeights[col];
		ctx.lineTo(x, y);
	}

	ctx.lineTo(W, H);
	ctx.closePath();
	ctx.fillStyle = grad;
	ctx.fill();
}

function draw(frame) {
	const W     = window.innerWidth;
	const H     = window.innerHeight;
	const scale = getScale();

	ctx.clearRect(0, 0, W, H);

	for (const f of flakes) {
		f.y += f.speed;
		f.x += f.drift + Math.sin(frame * CONFIG.oscSpeed + f.phase) * CONFIG.oscAmp;

		// Wrap horizontally so drift doesn't strand flakes off-screen.
		if (f.x < 0) f.x += W;
		if (f.x > W) f.x -= W;

		const pileTop = H - pileHeightAt(f.x);

		if (f.y + f.r * scale >= pileTop) {
			addToPile(f.x);
			Object.assign(f, spawnFlake(false));
			continue;
		}

		drawFlake(f, frame, scale);
	}

	smoothPile();
	drawPile();
}

// ─── REDUCED MOTION — static pile, no flakes ─────────────────────────────────

if (reducedMotion) {
	const staticHeight = window.innerHeight * CONFIG.pileMaxFraction * CONFIG.reducedMotionFraction;
	const jitter       = staticHeight * CONFIG.reducedMotionJitter;

	for (let col = 0; col < CONFIG.pileColumns; col++) {
		pileHeights[col] = staticHeight + (Math.random() - 0.5) * jitter;
	}

	drawPile();
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
