/**
 * Adrift — drifting clusters of warm particles, swept slowly left to right.
 *
 * Used by Chapter 001-buried ("Buried"). Particles gather in loose clusters
 * and wobble independently around each cluster's centre, all carried sideways
 * by a steady horizontal current. Reads as dust caught in late-summer air —
 * or memory motes hanging where they fell. Variety comes from per-particle
 * alpha and a radius distribution skewed toward small; the hue is the
 * chapter's ink-accent token.
 *
 * Canvas class  : x3p0-canvas-scene--adrift
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized but not drawn (mid-flight particles
 *                 would read as static debris, not motion)
 *
 * @file resources/js/canvas/scene/adrift.js
 */

import { setupCanvas, extractRGB, createCleanup } from 'x3p0/canvas-utils';

const canvas = document.querySelector( '.x3p0-canvas-scene--adrift' );

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// Number of clusters on screen at once.
	clusterCount: 9,

	// Particles per cluster — inclusive range.
	particlesMin: 2,
	particlesMax: 4,

	// Cluster horizontal drift speed (px/frame).
	speedMin: 0.22,
	speedMax: 0.50,

	// Cluster vertical drift — small sinusoidal wander (px/frame amplitude).
	vertDriftAmp: 0.08,

	// Particle radius range (px) and skew exponent. The skew biases the
	// distribution toward smaller values (>1 = more small particles).
	particleRadiusMin:  0.4,
	particleRadiusMax:  3.8,
	particleRadiusSkew: 1.8,

	// Per-particle alpha range.
	particleAlphaMin: 0.10,
	particleAlphaMax: 0.26,

	// How far particles spread from their cluster centre (px).
	particleSpreadX: 14,
	particleSpreadY: 10,

	// Per-particle wobble — sinusoidal oscillation around the cluster origin.
	wobbleAmpMin:   1.2,    // px
	wobbleAmpMax:   3.0,
	wobbleSpeedMin: 0.008,  // radians/frame
	wobbleSpeedMax: 0.014,

	// Cluster-level wobble speed — drives the cluster's own vertical wander.
	clusterWobbleSpeedMin: 0.012,  // radians/frame
	clusterWobbleSpeedMax: 0.020,

};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

( () => {
	const map = {
		clusterCount:          Number,
		particlesMin:          Number,
		particlesMax:          Number,
		speedMin:              Number,
		speedMax:              Number,
		vertDriftAmp:          Number,
		particleRadiusMin:     Number,
		particleRadiusMax:     Number,
		particleRadiusSkew:    Number,
		particleAlphaMin:      Number,
		particleAlphaMax:      Number,
		particleSpreadX:       Number,
		particleSpreadY:       Number,
		wobbleAmpMin:          Number,
		wobbleAmpMax:          Number,
		wobbleSpeedMin:        Number,
		wobbleSpeedMax:        Number,
		clusterWobbleSpeedMin: Number,
		clusterWobbleSpeedMax: Number,
	};

	Object.keys( map ).forEach( ( key ) => {
		if ( canvas.dataset[ key ] !== undefined ) {
			CONFIG[ key ] = map[ key ]( canvas.dataset[ key ] );
		}
	} );
} )();

// ─── CANVAS SETUP ────────────────────────────────────────────────────────────

const rafRef = { current: null };

const { ctx, resize } = setupCanvas( canvas );

// ─── REDUCED MOTION ──────────────────────────────────────────────────────────

const reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

// ─── COLOUR ──────────────────────────────────────────────────────────────────

let rgb = extractRGB( canvas, '--wp--preset--color--ink-accent', '122,64,16' );

// ─── EFFECT STATE ────────────────────────────────────────────────────────────

function randomBetween( min, max ) {
	return min + Math.random() * ( max - min );
}

function makeCluster( randomX ) {
	const W = window.innerWidth;
	const H = window.innerHeight;
	const n = CONFIG.particlesMin + Math.floor( Math.random() * ( CONFIG.particlesMax - CONFIG.particlesMin + 1 ) );

	const particles = [];

	for ( let i = 0; i < n; i++ ) {
		particles.push( {
			ox:           ( Math.random() - 0.5 ) * CONFIG.particleSpreadX,
			oy:           ( Math.random() - 0.5 ) * CONFIG.particleSpreadY,
			r:            CONFIG.particleRadiusMin + Math.pow( Math.random(), CONFIG.particleRadiusSkew ) * ( CONFIG.particleRadiusMax - CONFIG.particleRadiusMin ),
			alpha:        randomBetween( CONFIG.particleAlphaMin, CONFIG.particleAlphaMax ),
			wobbleOffset: Math.random() * Math.PI * 2,
			wobbleSpeed:  randomBetween( CONFIG.wobbleSpeedMin, CONFIG.wobbleSpeedMax ),
			wobbleAmp:    randomBetween( CONFIG.wobbleAmpMin,   CONFIG.wobbleAmpMax   ),
		} );
	}

	return {
		cx:           randomX ? Math.random() * W : -16,
		cy:           15 + Math.random() * ( H - 30 ),
		vx:           randomBetween( CONFIG.speedMin, CONFIG.speedMax ),
		vy:           ( Math.random() - 0.5 ) * CONFIG.vertDriftAmp,
		wobbleOffset: Math.random() * Math.PI * 2,
		wobbleSpeed:  randomBetween( CONFIG.clusterWobbleSpeedMin, CONFIG.clusterWobbleSpeedMax ),
		particles,
	};
}

const clusters = Array.from( { length: CONFIG.clusterCount }, () => makeCluster( true ) );

// ─── DRAW ────────────────────────────────────────────────────────────────────

function draw( t ) {
	const W = window.innerWidth;
	const H = window.innerHeight;

	ctx.clearRect( 0, 0, W, H );

	for ( let i = clusters.length - 1; i >= 0; i-- ) {
		const c = clusters[ i ];

		c.cx += c.vx;
		c.cy += c.vy + Math.sin( t * c.wobbleSpeed + c.wobbleOffset ) * 0.06;

		if ( c.cx > W + 24 ) {
			clusters.splice( i, 1 );
			clusters.push( makeCluster( false ) );
			continue;
		}

		c.particles.forEach( ( p ) => {
			const px = c.cx + p.ox + Math.sin( t * p.wobbleSpeed       + p.wobbleOffset ) * p.wobbleAmp;
			const py = c.cy + p.oy + Math.cos( t * p.wobbleSpeed * 0.7 + p.wobbleOffset ) * p.wobbleAmp * 0.5;

			ctx.beginPath();
			ctx.arc( px, py, p.r, 0, Math.PI * 2 );
			ctx.fillStyle = `rgba(${ rgb },${ p.alpha.toFixed( 3 ) })`;
			ctx.fill();
		} );
	}
}

// ─── REDUCED MOTION — skip drawing entirely ──────────────────────────────────

if ( reducedMotion ) {
	createCleanup( canvas, rafRef, resize );
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
	let t = 0;

	function tick() {
		t++;
		draw( t );
		rafRef.current = requestAnimationFrame( tick );
	}

	rafRef.current = requestAnimationFrame( tick );
	createCleanup( canvas, rafRef, resize );
}