/**
 * Motes — small particles drifting across a vertical band, occasionally
 * pausing or briefly drifting back as in an intermittent breeze.
 *
 * Used by Chapter 002 ("The Map I Drew"). Particles travel slowly left to
 * right within a band confined to the upper portion of the viewport — the
 * map zone. Each mote runs a tiny state machine (`drifting` / `paused` /
 * `reversing`) with low transition probabilities, so motion reads as
 * occasional natural pauses rather than scripted choreography. The effect
 * is subliminal: present enough to make the map feel like an outdoor
 * document, not so present that it competes with the prose.
 *
 * Canvas class  : x3p0-canvas-scene--motes
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized but not drawn (mid-flight motes would
 *                 read as flyspeck on a static page)
 *
 * @file resources/js/canvas/scene/motes.js
 */

import { setupCanvas, extractRGB, createCleanup } from 'x3p0/canvas-utils';

const canvas = document.querySelector( '.x3p0-canvas-scene--motes' );

// ─── CONFIG ──────────────────────────────────────────────────────────────────

const CONFIG = {

	// Number of motes on screen at once.
	moteCount: 10,

	// Horizontal drift speed range (px/frame, positive = rightward).
	// Kept very slow so motes are subliminal rather than distracting.
	driftSpeedMin: 0.08,
	driftSpeedMax: 0.28,

	// Vertical wobble — small sinusoidal wander (px/frame amplitude).
	verticalWobbleAmp: 0.06,

	// Vertical wobble cycle speed range (radians/frame).
	vertWobbleSpeedMin: 0.004,
	vertWobbleSpeedMax: 0.012,

	// State transition probabilities per frame. Low values — pauses and
	// reversals should feel occasional, not scheduled.
	pauseChance:    0.0008,
	reversalChance: 0.0003,

	// Pause duration range (frames).
	pauseDurationMin: 40,
	pauseDurationMax: 120,

	// Reversal duration range (frames).
	reversalDurationMin: 20,
	reversalDurationMax: 60,

	// Reversal drift is slower than forward drift — this multiplier scales
	// the mote's normal driftSpeed during the reversal state.
	reversalSpeedFactor: 0.4,

	// Per-mote alpha range. Low but perceptible.
	alphaMin: 0.12,
	alphaMax: 0.35,

	// Mote radius range (px).
	radiusMin: 0.8,
	radiusMax: 2.2,

	// Vertical band motes occupy, as fractions of viewport height
	// (0 = top, 1 = bottom). Restricts the effect to the map zone.
	bandTop:    0.0,
	bandBottom: 0.52,

	// Horizontal spawn x for recycled motes (just off the left edge).
	spawnOffsetLeft: -20,

	// Recycle threshold — motes recycle this far past the right edge.
	recycleOffsetRight: 30,

};

// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────────

( () => {
	const map = {
		moteCount:           Number,
		driftSpeedMin:       Number,
		driftSpeedMax:       Number,
		verticalWobbleAmp:   Number,
		vertWobbleSpeedMin:  Number,
		vertWobbleSpeedMax:  Number,
		pauseChance:         Number,
		reversalChance:      Number,
		pauseDurationMin:    Number,
		pauseDurationMax:    Number,
		reversalDurationMin: Number,
		reversalDurationMax: Number,
		reversalSpeedFactor: Number,
		alphaMin:            Number,
		alphaMax:            Number,
		radiusMin:           Number,
		radiusMax:           Number,
		bandTop:             Number,
		bandBottom:          Number,
		spawnOffsetLeft:     Number,
		recycleOffsetRight:  Number,
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

let rgb = extractRGB( canvas, '--wp--preset--color--ink-accent', '74,40,8' );

// ─── EFFECT STATE ────────────────────────────────────────────────────────────

function randomBetween( min, max ) {
	return min + Math.random() * ( max - min );
}

function randomIntBetween( min, max ) {
	return Math.floor( randomBetween( min, max + 1 ) );
}

function bandYRange() {
	const top    = CONFIG.bandTop    * window.innerHeight;
	const bottom = CONFIG.bandBottom * window.innerHeight;
	return { top, bottom };
}

function createMote( spawnAnywhere ) {
	const { top, bottom } = bandYRange();

	return {
		x:             spawnAnywhere ? randomBetween( 0, window.innerWidth ) : CONFIG.spawnOffsetLeft,
		y:             randomBetween( top, bottom ),
		radius:        randomBetween( CONFIG.radiusMin,       CONFIG.radiusMax       ),
		alpha:         randomBetween( CONFIG.alphaMin,        CONFIG.alphaMax        ),
		driftSpeed:    randomBetween( CONFIG.driftSpeedMin,   CONFIG.driftSpeedMax   ),
		vertOffset:    randomBetween( 0, Math.PI * 2 ),
		vertSpeed:     randomBetween( CONFIG.vertWobbleSpeedMin, CONFIG.vertWobbleSpeedMax ),
		state:         'drifting',  // 'drifting' | 'paused' | 'reversing'
		stateTimer:    0,
		stateDuration: 0,
	};
}

const motes = Array.from( { length: CONFIG.moteCount }, () => createMote( true ) );

// ─── DRAW ────────────────────────────────────────────────────────────────────

function updateMote( m ) {
	m.vertOffset += m.vertSpeed;
	m.y          += Math.sin( m.vertOffset ) * CONFIG.verticalWobbleAmp;

	const { top, bottom } = bandYRange();
	m.y = Math.max( top, Math.min( bottom, m.y ) );

	switch ( m.state ) {

		case 'drifting':
			m.x += m.driftSpeed;

			if ( Math.random() < CONFIG.pauseChance ) {
				m.state         = 'paused';
				m.stateTimer    = 0;
				m.stateDuration = randomIntBetween( CONFIG.pauseDurationMin, CONFIG.pauseDurationMax );
				break;
			}

			if ( Math.random() < CONFIG.reversalChance ) {
				m.state         = 'reversing';
				m.stateTimer    = 0;
				m.stateDuration = randomIntBetween( CONFIG.reversalDurationMin, CONFIG.reversalDurationMax );
			}
			break;

		case 'paused':
			m.stateTimer++;
			if ( m.stateTimer >= m.stateDuration ) m.state = 'drifting';
			break;

		case 'reversing':
			m.x -= m.driftSpeed * CONFIG.reversalSpeedFactor;
			m.stateTimer++;
			if ( m.stateTimer >= m.stateDuration ) m.state = 'drifting';
			break;
	}

	if ( m.x > window.innerWidth + CONFIG.recycleOffsetRight ) {
		Object.assign( m, createMote( false ) );
	}
}

function drawMote( m ) {
	ctx.beginPath();
	ctx.arc( m.x, m.y, m.radius, 0, Math.PI * 2 );
	ctx.fillStyle = `rgba(${ rgb },${ m.alpha.toFixed( 3 ) })`;
	ctx.fill();
}

function draw() {
	ctx.clearRect( 0, 0, window.innerWidth, window.innerHeight );

	for ( let i = 0; i < motes.length; i++ ) {
		updateMote( motes[ i ] );
		drawMote(   motes[ i ] );
	}
}

// ─── REDUCED MOTION — skip drawing entirely ──────────────────────────────────

if ( reducedMotion ) {
	createCleanup( canvas, rafRef, resize );
}

// ─── ANIMATION LOOP ──────────────────────────────────────────────────────────

else {
	function tick() {
		draw();
		rafRef.current = requestAnimationFrame( tick );
	}

	rafRef.current = requestAnimationFrame( tick );
	createCleanup( canvas, rafRef, resize );
}