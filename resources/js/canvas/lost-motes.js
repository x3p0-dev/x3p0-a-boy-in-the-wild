/**
 * Canvas effect: Moonbeam motes — 404 Lost page.
 *
 * Tiny particles of dust, pollen, and spore drifting slowly upward through
 * the moonbeam shaft. They are visible because the light catches them. They
 * drift laterally on cold air. They fade at the edges of the beam. They rise
 * because things rise in still cold air when something warm cuts through it.
 *
 * Canvas class : x3p0-canvas-bg--lost-motes
 * Position     : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized but never animated
 *
 * @file resources/js/canvas/chapter-lost-motes.js
 */

( function () {

	const canvas = document.querySelector( '.x3p0-canvas-bg--lost-motes' );

	if ( ! canvas ) {
		return;
	}

	const group = canvas.parentElement;
	const ctx   = canvas.getContext( '2d' );

	// ─── CONFIG ──────────────────────────────────────────────────────────────

	const CONFIG = {
		// Number of mote particles.
		moteCount: 55,

		// Horizontal origin as fraction of viewport width.
		// Motes spawn within the moonbeam shaft — centre third.
		originXMin: 0.34,
		originXMax: 0.66,

		// Vertical spawn band — lower two thirds of viewport.
		originYMin: 0.30,
		originYMax: 1.05,

		// Rise speed range (px/frame, negative = upward).
		riseSpeedMin: -0.22,
		riseSpeedMax: -0.07,

		// Lateral drift amplitude (px) — how far a mote wanders sideways.
		wobbleAmp: 0.55,

		// Wobble frequency — lower = lazier drift.
		wobbleFreq: 0.012,

		// Opacity range.
		alphaMin: 0.06,
		alphaMax: 0.28,

		// Fade rate per frame when a mote drifts outside the beam.
		fadeRate: 0.004,

		// Particle radius range (px).
		radiusMin: 0.6,
		radiusMax: 1.8,

		// Glow radius multiplier — soft halo around each mote.
		glowRadiusMultiplier: 3.2,

		// Glow opacity as a fraction of the mote's current alpha.
		glowAlphaFraction: 0.18,
	};

	// ─── CANVAS SETUP ────────────────────────────────────────────────────────

	function resize() {
		canvas.width  = window.innerWidth;
		canvas.height = window.innerHeight;
	}

	resize();
	window.addEventListener( 'resize', resize );

	// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────

	( function () {
		const map = {
			moteCount:            Number,
			originXMin:           Number,
			originXMax:           Number,
			originYMin:           Number,
			originYMax:           Number,
			riseSpeedMin:         Number,
			riseSpeedMax:         Number,
			wobbleAmp:            Number,
			wobbleFreq:           Number,
			alphaMin:             Number,
			alphaMax:             Number,
			fadeRate:             Number,
			radiusMin:            Number,
			radiusMax:            Number,
			glowRadiusMultiplier: Number,
			glowAlphaFraction:    Number,
		};

		Object.keys( map ).forEach( ( key ) => {
			if ( canvas.dataset[ key ] !== undefined ) {
				CONFIG[ key ] = map[ key ]( canvas.dataset[ key ] );
			}
		} );
	} )();

	// ─── REDUCED MOTION GUARD ────────────────────────────────────────────────

	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	// ─── COLOUR ──────────────────────────────────────────────────────────────

	// Read ink-accent directly from the style variation — used as-is.
	// Alpha is controlled per-particle via ctx.globalAlpha.
	// Fallback: late-summer ink-accent.
	const style     = getComputedStyle( group );
	const fillColor = style.getPropertyValue( '--wp--preset--color--ink-accent' ).trim()
		|| '#4a2808';

	// ─── PARTICLE SYSTEM ─────────────────────────────────────────────────────

	function rand( min, max ) {
		return min + Math.random() * ( max - min );
	}

	function spawnMote() {
		return {
			x:      rand( CONFIG.originXMin, CONFIG.originXMax ) * canvas.width,
			y:      rand( CONFIG.originYMin, CONFIG.originYMax ) * canvas.height,
			vy:     rand( CONFIG.riseSpeedMin, CONFIG.riseSpeedMax ),
			vx:     rand( -0.06, 0.06 ),
			alpha:  rand( CONFIG.alphaMin, CONFIG.alphaMax ),
			radius: rand( CONFIG.radiusMin, CONFIG.radiusMax ),
			phase:  rand( 0, Math.PI * 2 ),
			freq:   CONFIG.wobbleFreq * rand( 0.7, 1.3 ),
		};
	}

	const motes = Array.from( { length: CONFIG.moteCount }, spawnMote );

	// ─── DRAW ─────────────────────────────────────────────────────────────────

	function drawMote( m ) {
		// Glow halo
		const glowR = m.radius * CONFIG.glowRadiusMultiplier;
		const glow  = ctx.createRadialGradient( m.x, m.y, 0, m.x, m.y, glowR );

		ctx.globalAlpha = m.alpha * CONFIG.glowAlphaFraction;
		glow.addColorStop( 0, fillColor );
		glow.addColorStop( 1, 'transparent' );

		ctx.beginPath();
		ctx.arc( m.x, m.y, glowR, 0, Math.PI * 2 );
		ctx.fillStyle = glow;
		ctx.fill();

		// Mote core
		ctx.globalAlpha = m.alpha;
		ctx.fillStyle   = fillColor;
		ctx.beginPath();
		ctx.arc( m.x, m.y, m.radius, 0, Math.PI * 2 );
		ctx.fill();
	}

	// ─── ANIMATION LOOP ───────────────────────────────────────────────────────

	let t     = 0;
	let rafId = null;

	function tick() {
		ctx.clearRect( 0, 0, canvas.width, canvas.height );
		ctx.globalAlpha = 1;

		for ( const m of motes ) {
			m.y += m.vy;
			m.x += m.vx + Math.sin( t * m.freq * 60 + m.phase ) * CONFIG.wobbleAmp;

			// Fade motes that drift outside the beam
			const beamMin = CONFIG.originXMin * canvas.width;
			const beamMax = CONFIG.originXMax * canvas.width;

			if ( m.x < beamMin || m.x > beamMax ) {
				m.alpha = Math.max( 0, m.alpha - CONFIG.fadeRate );
			}

			// Recycle when invisible or above viewport
			if ( m.alpha <= 0 || m.y < -10 ) {
				Object.assign( m, spawnMote() );
			}

			drawMote( m );
		}

		ctx.globalAlpha = 1;
		t    += 0.016;
		rafId = requestAnimationFrame( tick );
	}

	rafId = requestAnimationFrame( tick );

	// ─── CLEANUP ─────────────────────────────────────────────────────────────

	const observer = new MutationObserver( () => {
		if ( ! document.contains( group ) ) {
			cancelAnimationFrame( rafId );
			window.removeEventListener( 'resize', resize );
			observer.disconnect();
		}
	} );

	observer.observe( document.body, { childList: true, subtree: true } );

} )();
