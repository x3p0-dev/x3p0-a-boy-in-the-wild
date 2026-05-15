/**
 * Canvas effect: Lost terrain — 404 Lost page.
 *
 * Flow field contour lines suggesting unmapped terrain. Adapted from the
 * spine arc flow field but retuned for disorientation — three asymmetric
 * sine harmonics produce a field that drifts without settling. The spine
 * terrain feels like known ground. This terrain has no name because no one
 * has walked it before.
 *
 * Canvas class : x3p0-canvas-bg--lost-terrain
 * Position     : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized, drawn once, then static
 *
 * @file resources/js/canvas/chapter-lost-terrain.js
 */

( function () {

	const canvas = document.querySelector( '.x3p0-canvas-bg--lost-terrain' );

	if ( ! canvas ) {
		return;
	}

	const group = canvas.parentElement;
	const ctx   = canvas.getContext( '2d' );

	// ─── CONFIG ──────────────────────────────────────────────────────────────

	const CONFIG = {
		// Number of seed lines in the flow field.
		lineCount: 260,

		// Steps per line — how far each line travels before stopping.
		lineLength: 220,

		// Step size (px) between each point along a line.
		stepSize: 3.8,

		// Opacity range for individual lines.
		alphaMin: 0.04,
		alphaMax: 0.11,

		// Line width range (px).
		widthMin: 0.4,
		widthMax: 0.9,

		// How fast the field drifts over time.
		// Lower = slower, more disorienting.
		driftSpeed: 0.0015,

		// Field angle harmonics — three sine layers.
		// Asymmetric frequencies make the terrain feel unreadable.
		harmonic1Freq: 0.008,
		harmonic1Amp:  1.0,
		harmonic2Freq: 0.013,
		harmonic2Amp:  0.5,
		harmonic3Freq: 0.022,
		harmonic3Amp:  0.25,
	};

	// ─── CANVAS SETUP ────────────────────────────────────────────────────────

	let seeds = null;

	function resize() {
		canvas.width  = window.innerWidth;
		canvas.height = window.innerHeight;
		seeds         = buildSeeds();
	}

	resize();
	window.addEventListener( 'resize', resize );

	// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────

	( function () {
		const map = {
			lineCount:      Number,
			lineLength:     Number,
			stepSize:       Number,
			alphaMin:       Number,
			alphaMax:       Number,
			widthMin:       Number,
			widthMax:       Number,
			driftSpeed:     Number,
			harmonic1Freq:  Number,
			harmonic1Amp:   Number,
			harmonic2Freq:  Number,
			harmonic2Amp:   Number,
			harmonic3Freq:  Number,
			harmonic3Amp:   Number,
		};

		Object.keys( map ).forEach( ( key ) => {
			if ( canvas.dataset[ key ] !== undefined ) {
				CONFIG[ key ] = map[ key ]( canvas.dataset[ key ] );
			}
		} );
	} )();

	// ─── REDUCED MOTION GUARD ────────────────────────────────────────────────

	// For reduced motion: draw once and return. The terrain is static —
	// a snapshot of ground that cannot be read, rather than ground that drifts.
	const reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// ─── COLOUR ──────────────────────────────────────────────────────────────

	// Read rule token directly from the style variation — used as-is.
	// Alpha is controlled per-line via ctx.globalAlpha.
	// Fallback: late-summer rule colour.
	const style       = getComputedStyle( group );
	const strokeColor = style.getPropertyValue( '--wp--preset--color--rule' ).trim()
		|| 'rgba(130,72,14,0.22)';

	// ─── FLOW FIELD ───────────────────────────────────────────────────────────

	// Vector field angle at (x, y, t) — three asymmetric sine harmonics.
	function fieldAngle( x, y, t ) {
		const a1 = Math.sin( x * CONFIG.harmonic1Freq + t * 0.7 )
			* Math.cos( y * CONFIG.harmonic1Freq * 0.9 + t * 0.5 )
			* CONFIG.harmonic1Amp;
		const a2 = Math.sin( x * CONFIG.harmonic2Freq - y * CONFIG.harmonic2Freq * 1.1 + t * 0.4 )
			* CONFIG.harmonic2Amp;
		const a3 = Math.cos( x * CONFIG.harmonic3Freq * 0.8 + y * CONFIG.harmonic3Freq + t * 0.3 )
			* CONFIG.harmonic3Amp;
		return ( a1 + a2 + a3 ) * Math.PI;
	}

	// ─── SEEDS ───────────────────────────────────────────────────────────────

	function buildSeeds() {
		const list = [];
		for ( let i = 0; i < CONFIG.lineCount; i++ ) {
			list.push( {
				x0:    Math.random() * canvas.width,
				y0:    Math.random() * canvas.height,
				alpha: CONFIG.alphaMin + Math.random() * ( CONFIG.alphaMax - CONFIG.alphaMin ),
				width: CONFIG.widthMin + Math.random() * ( CONFIG.widthMax - CONFIG.widthMin ),
			} );
		}
		return list;
	}

	// ─── DRAW ─────────────────────────────────────────────────────────────────

	function drawFrame( t ) {
		ctx.clearRect( 0, 0, canvas.width, canvas.height );
		ctx.strokeStyle = strokeColor;
		ctx.lineCap     = 'round';

		for ( const s of seeds ) {
			let x = s.x0;
			let y = s.y0;

			ctx.globalAlpha = s.alpha;
			ctx.lineWidth   = s.width;
			ctx.beginPath();
			ctx.moveTo( x, y );

			for ( let step = 0; step < CONFIG.lineLength; step++ ) {
				const angle = fieldAngle( x, y, t );
				x += Math.cos( angle ) * CONFIG.stepSize;
				y += Math.sin( angle ) * CONFIG.stepSize;
				ctx.lineTo( x, y );

				if ( x < -20 || x > canvas.width  + 20 ||
					y < -20 || y > canvas.height + 20 ) {
					break;
				}
			}

			ctx.stroke();
		}

		ctx.globalAlpha = 1;
	}

	// Draw once for reduced motion — static snapshot of unmapped terrain.
	if ( reducedMotion ) {
		drawFrame( 0 );
		return;
	}

	// ─── ANIMATION LOOP ───────────────────────────────────────────────────────

	let t     = 0;
	let rafId = null;

	function tick() {
		drawFrame( t );
		t    += CONFIG.driftSpeed;
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
