/**
 * Flow field — contour lines tracing an organic vector field.
 *
 * Intended for the Spine arc chapters (not yet wired up). A grid of angles
 * is sampled from layered sine harmonics; 300 seed points then trace lines
 * along the field, drawing contours that suggest terrain at a low level of
 * detail. The field drifts very slowly over time. Lines alternate between
 * high- and low-opacity bands so the contours read as a stratified map
 * rather than a uniform mesh.
 *
 * Colour is the chapter's `--rule` token. The token's intentional alpha
 * (e.g. 0.18 in the spine palette) multiplies through every line so the
 * contours sit far back from the prose.
 *
 * Canvas class  : x3p0-canvas-scene--flow-field
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: drawn once at t=0, then static (a snapshot of contours
 *                 is meaningful — it reads as a map, not a frozen moment)
 *
 * @file resources/js/canvas/scene/flow-field.js
 */

import { setupCanvas, extractColour, withAlpha, createCleanup } from 'x3p0/canvas-utils';

const canvas = document.querySelector( '.x3p0-canvas-scene--flow-field' );

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// Number of seed lines drawn each frame.
	lineCount: 300,

	// Flow field grid resolution (columns × rows). The grid is sampled
	// from noise once per frame, then bilinear-lookup'd per-seed.
	fieldCols: 120,
	fieldRows: 60,

	// Step size per line segment (px). x and y differ to bias contours
	// slightly horizontal — terrain on a map reads sideways more than down.
	stepX: 2.4,
	stepY: 1.8,

	// Segment count range per line.
	segmentsMin: 80,
	segmentsMax: 300,

	// Opacity bands. Lines are divided into `bandCount` groups; even bands
	// use the high opacity range, odd bands the low one. The result reads
	// as stratified contour shading.
	//
	// These values are multipliers on top of the token's alpha (see
	// withAlpha() in utils). They are tuned against the spine palette's
	// `--rule` token (alpha 0.18) — if the effect is reused with a palette
	// whose `--rule` has a different alpha, the contours will be
	// proportionally brighter or fainter.
	bandCount:      10,
	opacityHighMin: 0.39,
	opacityHighMax: 0.67,
	opacityLowMin:  0.11,
	opacityLowMax:  0.25,

	// Stroke width (px).
	lineWidth: 0.65,

	// Field drift speed (t increment per frame). Very low = very slow.
	driftSpeed: 0.00035,

	// Noise sampling — how compressed the field is across the canvas.
	// Higher = tighter contours (more topology per unit area).
	noiseXScale: 2.5,
	noiseYScale: 2.0,

	// How far past the viewport edge a line may wander before it terminates.
	wanderMargin: 5,

	// Noise harmonic weights. Each entry: [ yFreq, xFreq, tFreq, weight ].
	harmonics: [
		[ 0.8, 0.15, 0.50, 0.60 ],
		[ 1.8, 0.25, 0.35, 0.25 ],
		[ 3.2, 0.10, 0.20, 0.10 ],
		[ 0.0, 0.50, 0.15, 0.05 ],
	],

};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

( () => {
	const map = {
		lineCount:      Number,
		fieldCols:      Number,
		fieldRows:      Number,
		stepX:          Number,
		stepY:          Number,
		segmentsMin:    Number,
		segmentsMax:    Number,
		bandCount:      Number,
		opacityHighMin: Number,
		opacityHighMax: Number,
		opacityLowMin:  Number,
		opacityLowMax:  Number,
		lineWidth:      Number,
		driftSpeed:     Number,
		noiseXScale:    Number,
		noiseYScale:    Number,
		wanderMargin:   Number,
		// `harmonics` is intentionally not data-overridable — it's a
		// structured value, not a scalar.
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

// Spine palette's `--rule` carries an intentional 0.18 alpha; withAlpha()
// multiplies it through per-line so the contours stay well back from the prose.
let colour = extractColour( canvas, '--wp--preset--color--rule', '90,55,12,0.18' );

// ─── EFFECT STATE ────────────────────────────────────────────────────────────

function noise( x, y, t ) {
	let value = 0;

	for ( const [ yFreq, xFreq, tFreq, weight ] of CONFIG.harmonics ) {
		const yTerm = yFreq > 0 ? yFreq * y : 0;
		value += Math.sin( yTerm + xFreq * x + tFreq * t ) * weight;
	}

	return value;
}

const field = [];

function buildField( t ) {
	const { fieldCols, fieldRows, noiseXScale, noiseYScale } = CONFIG;

	for ( let r = 0; r <= fieldRows; r++ ) {
		if ( ! field[ r ] ) field[ r ] = [];

		for ( let c = 0; c <= fieldCols; c++ ) {
			field[ r ][ c ] = noise(
				( c / fieldCols ) * noiseXScale,
				( r / fieldRows ) * noiseYScale,
				t
			) * Math.PI;
		}
	}
}

function getAngle( x, y ) {
	const { fieldCols, fieldRows } = CONFIG;
	const c = Math.min( Math.max( Math.floor( x / window.innerWidth  * fieldCols ), 0 ), fieldCols - 1 );
	const r = Math.min( Math.max( Math.floor( y / window.innerHeight * fieldRows ), 0 ), fieldRows - 1 );
	return field[ r ]?.[ c ] ?? 0;
}

const seeds = Array.from( { length: CONFIG.lineCount }, ( _, i ) => {
	const band   = Math.floor( i / ( CONFIG.lineCount / CONFIG.bandCount ) );
	const isHigh = band % 2 === 0;
	const opacity = isHigh
		? CONFIG.opacityHighMin + Math.random() * ( CONFIG.opacityHighMax - CONFIG.opacityHighMin )
		: CONFIG.opacityLowMin  + Math.random() * ( CONFIG.opacityLowMax  - CONFIG.opacityLowMin  );

	return {
		x:        Math.random() * window.innerWidth,
		y:        Math.random() * window.innerHeight,
		segments: Math.floor( CONFIG.segmentsMin + Math.random() * ( CONFIG.segmentsMax - CONFIG.segmentsMin ) ),
		opacity,
	};
} );

// ─── DRAW ────────────────────────────────────────────────────────────────────

function draw( t ) {
	const W = window.innerWidth;
	const H = window.innerHeight;
	const M = CONFIG.wanderMargin;

	buildField( t );
	ctx.clearRect( 0, 0, W, H );
	ctx.lineWidth = CONFIG.lineWidth;

	for ( const s of seeds ) {
		let x = s.x;
		let y = s.y;

		ctx.strokeStyle = withAlpha( colour, s.opacity );
		ctx.beginPath();
		ctx.moveTo( x, y );

		for ( let i = 0; i < s.segments; i++ ) {
			const a = getAngle( x, y );
			x += Math.cos( a ) * CONFIG.stepX;
			y += Math.sin( a ) * CONFIG.stepY;

			if ( x < -M || x > W + M || y < -M || y > H + M ) break;

			ctx.lineTo( x, y );
		}

		ctx.stroke();
	}
}

// ─── REDUCED MOTION — draw once at t=0, then stop ────────────────────────────

if ( reducedMotion ) {
	draw( 0 );
	createCleanup( canvas, rafRef, resize );
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
	let t = 0;

	function tick() {
		t += CONFIG.driftSpeed;
		draw( t );
		rafRef.current = requestAnimationFrame( tick );
	}

	rafRef.current = requestAnimationFrame( tick );
	createCleanup( canvas, rafRef, resize );
}
