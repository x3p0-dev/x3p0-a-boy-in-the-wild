/**
 * Lost moon — moonlight scene for the 404 page.
 *
 * Renders the full moonlight composition: a disc sitting just above the top
 * edge of the viewport, two static halo rings, a volumetric beam shaft
 * falling through a forest gap, and three soft ground pools of reflected
 * light. The bloom pulses very slowly — not flickering, just breathing,
 * the way moonlight feels once your eyes have adjusted and the forest seems
 * to shift without anything actually moving. The beam has a faint cold-air
 * shimmer on an independent cycle so the two never sync.
 *
 * Two palette tokens drive the colour:
 *   `--ink-accent` — atmospheric amber-gold, used everywhere the light hits
 *                    air or ground (bloom, halos, beam, inner beam, pools).
 *   `--ink`        — luminous cream-warm, used only for the moon disc. The
 *                    moon is the source; everything else is what the source
 *                    illuminates.
 *
 * Canvas class  : x3p0-canvas-scene--lost-moon
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: drawn once at mid-pulse, then static
 *
 * @file resources/js/canvas/scene/lost-moon.js
 */

import {setupCanvas, extractColour, withAlpha, createCleanup} from 'x3p0/canvas-utils';

const canvas = document.querySelector('.x3p0-canvas-scene--lost-moon');

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// Moon centre, as fractions of viewport size.
	// moonY < 0 keeps the disc partly above the top edge.
	moonX: 0.5,
	moonY: -0.048,

	// Moon disc radius as a fraction of viewport height.
	moonRadius: 0.098,

	// Halo ring radii and static opacities.
	haloRadius1:  0.168,
	haloRadius2:  0.215,
	haloOpacity1: 0.07,
	haloOpacity2: 0.045,

	// Moon bloom — outer atmospheric glow. The pulse is barely perceptible.
	bloomRadius:        0.62,    // fraction of viewport height
	bloomOpacityMin:    0.055,
	bloomOpacityMax:    0.095,
	bloomPulseDuration: 10000,   // ms — one full cycle

	// Beam shaft — wide cone from moon to ground.
	beamWidthBase:       0.28,   // fraction of viewport width at the floor
	beamWidthTop:        0.06,   // fraction of viewport width at the top
	beamOpacityMin:      0.038,
	beamOpacityMax:      0.065,
	beamShimmerDuration: 7500,   // ms — one full cycle
	beamShimmerPhase:    1.2,    // radian phase offset from the bloom pulse

	// Inner beam — tighter, more luminous core. Static opacity.
	innerBeamWidthBase: 0.14,
	innerBeamWidthTop:  0.032,
	innerBeamOpacity:   0.048,
	innerBeamReach:     0.72,    // fraction of viewport height the core extends to

	// Ground pool — directly under the beam.
	poolCentreRadius:  0.32,     // fraction of viewport width
	poolCentreOpacity: 0.088,

	// Ground pools — left and right secondary reflections.
	poolSideRadius:  0.22,       // fraction of viewport width
	poolSideOpacity: 0.055,
	poolLeftX:       0.26,       // fraction of viewport width
	poolRightX:      0.74,
	poolY:           0.88,       // fraction of viewport height

	// Moon disc — alpha at centre and edge of the disc gradient.
	discAlphaCentre:  1.0,
	discAlphaEdge:    0.30,
	discOverallAlpha: 0.92,      // applied as globalAlpha across the disc

	// Moon disc — inner highlight offset (fraction of moon radius, upward).
	discHighlightOffset: 0.15,

	// Crater texture overlay opacity.
	craterOpacity: 0.055
};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

(() => {
	const map = {
		moonX:               Number,
		moonY:               Number,
		moonRadius:          Number,
		haloRadius1:         Number,
		haloRadius2:         Number,
		haloOpacity1:        Number,
		haloOpacity2:        Number,
		bloomRadius:         Number,
		bloomOpacityMin:     Number,
		bloomOpacityMax:     Number,
		bloomPulseDuration:  Number,
		beamWidthBase:       Number,
		beamWidthTop:        Number,
		beamOpacityMin:      Number,
		beamOpacityMax:      Number,
		beamShimmerDuration: Number,
		beamShimmerPhase:    Number,
		innerBeamWidthBase:  Number,
		innerBeamWidthTop:   Number,
		innerBeamOpacity:    Number,
		innerBeamReach:      Number,
		poolCentreRadius:    Number,
		poolCentreOpacity:   Number,
		poolSideRadius:      Number,
		poolSideOpacity:     Number,
		poolLeftX:           Number,
		poolRightX:          Number,
		poolY:               Number,
		discAlphaCentre:     Number,
		discAlphaEdge:       Number,
		discOverallAlpha:    Number,
		discHighlightOffset: Number,
		craterOpacity:       Number
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

// Atmospheric amber — what the light *touches*. Mood-lost gives this an
// alpha of 0.72, which is part of how subtle moon-on-air should feel.
let glow = extractColour(canvas, '--wp--preset--color--ink-accent', '200,178,85,0.72' );

// Luminous cream-warm — what the light *is*. Mood-lost gives this 0.90.
let disc = extractColour(canvas, '--wp--preset--color--ink',        '215,205,158,0.90');

// ─── DRAW ────────────────────────────────────────────────────────────────────

function drawFrame(bloomAlpha, beamAlpha) {
	const W  = window.innerWidth;
	const H  = window.innerHeight;
	const MX = CONFIG.moonX      * W;
	const MY = CONFIG.moonY      * H;
	const MR = CONFIG.moonRadius * H;

	ctx.clearRect(0, 0, W, H);

	// ── Bloom — outer atmospheric glow ───────────────────────────────────────
	const bloom = ctx.createRadialGradient(MX, MY, 0, MX, MY, CONFIG.bloomRadius * H);
	bloom.addColorStop(0,    withAlpha(glow, 1));
	bloom.addColorStop(0.25, withAlpha(glow, 1));
	bloom.addColorStop(1,    withAlpha(glow, 0));

	ctx.globalAlpha = bloomAlpha;
	ctx.fillStyle   = bloom;
	ctx.fillRect(0, 0, W, H);

	// ── Halo rings ───────────────────────────────────────────────────────────
	ctx.strokeStyle = withAlpha(glow, 1);

	ctx.globalAlpha = CONFIG.haloOpacity1;
	ctx.lineWidth   = 1.5;
	ctx.beginPath();
	ctx.arc(MX, MY, CONFIG.haloRadius1 * H, 0, Math.PI * 2);
	ctx.stroke();

	ctx.globalAlpha = CONFIG.haloOpacity2;
	ctx.lineWidth   = 1;
	ctx.beginPath();
	ctx.arc(MX, MY, CONFIG.haloRadius2 * H, 0, Math.PI * 2);
	ctx.stroke();

	// ── Beam shaft — wide cone, animated shimmer ─────────────────────────────
	const beamBase = (CONFIG.beamWidthBase / 2) * W;
	const beamTop  = (CONFIG.beamWidthTop  / 2) * W;
	const beamGrad = ctx.createLinearGradient(MX, 0, MX, H);
	beamGrad.addColorStop(0,    withAlpha(glow, 1));
	beamGrad.addColorStop(0.22, withAlpha(glow, 1));
	beamGrad.addColorStop(0.62, withAlpha(glow, 1));
	beamGrad.addColorStop(1,    withAlpha(glow, 0));

	ctx.globalAlpha = beamAlpha;
	ctx.fillStyle   = beamGrad;
	ctx.beginPath();
	ctx.moveTo(MX - beamTop,  0);
	ctx.lineTo(MX - beamBase, H);
	ctx.lineTo(MX + beamBase, H);
	ctx.lineTo(MX + beamTop,  0);
	ctx.closePath();
	ctx.fill();

	// ── Inner beam — tighter luminous core ───────────────────────────────────
	const innerBase  = (CONFIG.innerBeamWidthBase / 2) * W;
	const innerTop   = (CONFIG.innerBeamWidthTop  / 2) * W;
	const innerReach = H * CONFIG.innerBeamReach;
	const innerGrad  = ctx.createLinearGradient(MX, 0, MX, innerReach);
	innerGrad.addColorStop(0,   withAlpha(glow, 1));
	innerGrad.addColorStop(0.5, withAlpha(glow, 1));
	innerGrad.addColorStop(1,   withAlpha(glow, 0));

	ctx.globalAlpha = CONFIG.innerBeamOpacity;
	ctx.fillStyle   = innerGrad;
	ctx.beginPath();
	ctx.moveTo(MX - innerTop,  0);
	ctx.lineTo(MX - innerBase, innerReach);
	ctx.lineTo(MX + innerBase, innerReach);
	ctx.lineTo(MX + innerTop,  0);
	ctx.closePath();
	ctx.fill();

	// ── Ground pools — soft reflected light ──────────────────────────────────
	drawPool(MX,                  H,                CONFIG.poolCentreRadius * W, CONFIG.poolCentreOpacity);
	drawPool(CONFIG.poolLeftX  * W, CONFIG.poolY * H, CONFIG.poolSideRadius   * W, CONFIG.poolSideOpacity  );
	drawPool(CONFIG.poolRightX * W, CONFIG.poolY * H, CONFIG.poolSideRadius   * W, CONFIG.poolSideOpacity  );

	// ── Moon disc — drawn last so it sits above the bloom ────────────────────
	const moonGrad = ctx.createRadialGradient(
		MX, MY - MR * CONFIG.discHighlightOffset, 0,
		MX, MY, MR
	);
	moonGrad.addColorStop(0,   withAlpha(disc, CONFIG.discAlphaCentre));
	moonGrad.addColorStop(0.8, withAlpha(disc, CONFIG.discAlphaCentre));
	moonGrad.addColorStop(1,   withAlpha(disc, CONFIG.discAlphaEdge  ));

	ctx.globalAlpha = CONFIG.discOverallAlpha;
	ctx.fillStyle   = moonGrad;
	ctx.beginPath();
	ctx.arc(MX, MY, MR, 0, Math.PI * 2);
	ctx.fill();

	// ── Craters — three subtle amber patches over the disc ───────────────────
	ctx.globalAlpha = CONFIG.craterOpacity;
	ctx.fillStyle   = withAlpha(glow, 1);
	ctx.beginPath();
	ctx.arc(MX - MR * 0.27, MY - MR * 0.20, MR * 0.20, 0, Math.PI * 2);
	ctx.fill();
	ctx.beginPath();
	ctx.arc(MX + MR * 0.37, MY + MR * 0.13, MR * 0.13, 0, Math.PI * 2);
	ctx.fill();
	ctx.beginPath();
	ctx.arc(MX - MR * 0.09, MY + MR * 0.30, MR * 0.16, 0, Math.PI * 2);
	ctx.fill();

	ctx.globalAlpha = 1;
}

function drawPool(x, y, r, alpha) {
	const grad = ctx.createRadialGradient(x, y, 0, x, y, r);
	grad.addColorStop(0,   withAlpha(glow, 1));
	grad.addColorStop(0.5, withAlpha(glow, 1));
	grad.addColorStop(1,   withAlpha(glow, 0));

	ctx.globalAlpha = alpha;
	ctx.fillStyle   = grad;
	ctx.fillRect(0, 0, window.innerWidth, window.innerHeight);
}

// ─── REDUCED MOTION — draw once at mid-pulse, then stop ──────────────────────

if (reducedMotion) {
	const midBloom = (CONFIG.bloomOpacityMin + CONFIG.bloomOpacityMax) / 2;
	const midBeam  = (CONFIG.beamOpacityMin  + CONFIG.beamOpacityMax ) / 2;
	drawFrame(midBloom, midBeam);
	createCleanup(canvas, rafRef, resize);
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
	function tick(timestamp) {
		const bloomPhase = (timestamp % CONFIG.bloomPulseDuration) / CONFIG.bloomPulseDuration;
		const bloomAlpha = CONFIG.bloomOpacityMin
			+ (CONFIG.bloomOpacityMax - CONFIG.bloomOpacityMin)
			* (0.5 + 0.5 * Math.sin(bloomPhase * Math.PI * 2));

		const beamPhase = (timestamp % CONFIG.beamShimmerDuration) / CONFIG.beamShimmerDuration;
		const beamAlpha = CONFIG.beamOpacityMin
			+ (CONFIG.beamOpacityMax - CONFIG.beamOpacityMin)
			* (0.5 + 0.5 * Math.sin(beamPhase * Math.PI * 2 + CONFIG.beamShimmerPhase));

		drawFrame(bloomAlpha, beamAlpha);
		rafRef.current = requestAnimationFrame(tick);
	}

	rafRef.current = requestAnimationFrame(tick);
	createCleanup(canvas, rafRef, resize);
}
