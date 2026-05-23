/**
 * Flow field — contour line canvas effect.
 *
 * Used by all Spine arc chapters. 300 seed lines follow a vector field built
 * from layered sine harmonics to approximate organic terrain contours. The
 * field drifts very slowly. Colour is derived from the chapter's rule token.
 *
 * Canvas class  : x3p0-canvas-bg--flow-field
 * Position      : fixed — fills the viewport regardless of scroll * Reduced motion: canvas is sized, drawn once at t=0, then static
 *
 * @file resources/js/canvas/flow-field.js
 */

( function () {

	const canvas = document.querySelector( '.x3p0-canvas-bg--flow-field' );

	if ( ! canvas ) {
		return;
	}

	const group = canvas.parentElement;
	const ctx   = canvas.getContext( '2d' );

	// ─── CONFIG ──────────────────────────────────────────────────────────────

	const CONFIG = {
		// Number of seed lines drawn each frame.
		lineCount: 300,

		// Flow field grid resolution (columns × rows).
		fieldCols: 120,
		fieldRows: 60,

		// Step size per segment (px). x and y differ to produce
		// slightly horizontal-biased contours.
		stepX: 2.4,
		stepY: 1.8,

		// Segment count range per line.
		segmentsMin: 80,
		segmentsMax: 300,

		// Opacity bands — lines alternate between a more-visible and
		// less-visible band. bandCount controls how many bands the
		// lines are divided into.
		bandCount:      10,
		opacityHighMin: 0.07,
		opacityHighMax: 0.12,
		opacityLowMin:  0.02,
		opacityLowMax:  0.045,

		// Stroke width (px).
		lineWidth: 0.65,

		// Field drift speed (t increment per frame). Very low = very slow drift.
		driftSpeed: 0.00035,

		// Noise harmonic weights.
		// Each entry: [ yFreq, xFreq, tFreq, weight ]
		harmonics: [
			[ 0.8,  0.15, 0.50, 0.60 ],
			[ 1.8,  0.25, 0.35, 0.25 ],
			[ 3.2,  0.10, 0.20, 0.10 ],
			[ 0.0,  0.50, 0.15, 0.05 ],
		],
	};

	// ─── CANVAS SETUP ────────────────────────────────────────────────────────

	let rgb = '';

	function resize() {
		const dpr     = window.devicePixelRatio || 1;
		canvas.width  = window.innerWidth  * dpr;
		canvas.height = window.innerHeight * dpr;
		ctx.scale( dpr, dpr );
		rgb = extractRGB();
	}

	resize();
	window.addEventListener( 'resize', resize );

	// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────

	( function () {
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
		};

		Object.keys( map ).forEach( ( key ) => {
			if ( canvas.dataset[ key ] !== undefined ) {
				CONFIG[ key ] = map[ key ]( canvas.dataset[ key ] );
			}
		} );
	} )();

	// ─── REDUCED MOTION ──────────────────────────────────────────────────────

	const reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// ─── FLOW FIELD ──────────────────────────────────────────────────────────

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
		const { fieldCols, fieldRows } = CONFIG;

		for ( let r = 0; r <= fieldRows; r++ ) {
			if ( ! field[ r ] ) {
				field[ r ] = [];
			}

			for ( let c = 0; c <= fieldCols; c++ ) {
				field[ r ][ c ] = noise(
					( c / fieldCols ) * 2.5,
					( r / fieldRows ) * 2,
					t
				) * Math.PI;
			}
		}
	}

	function getAngle( x, y ) {
		const { fieldCols, fieldRows } = CONFIG;
		const dpr = window.devicePixelRatio || 1;
		const c = Math.min( Math.max( Math.floor( x / ( canvas.width  / dpr ) * fieldCols ), 0 ), fieldCols - 1 );
		const r = Math.min( Math.max( Math.floor( y / ( canvas.height / dpr ) * fieldRows ), 0 ), fieldRows - 1 );
		return field[ r ]?.[ c ] ?? 0;
	}

	// ─── SEEDS ───────────────────────────────────────────────────────────────

	const seeds = Array.from( { length: CONFIG.lineCount }, ( _, i ) => {
		const band    = Math.floor( i / ( CONFIG.lineCount / CONFIG.bandCount ) );
		const isHigh  = band % 2 === 0;
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

	// ─── COLOUR ──────────────────────────────────────────────────────────────

	// Extract the RGB components from the rule token once so we can cheaply
	// rebuild the colour string per line with each seed's opacity as the alpha.
	// The token contains its own alpha (e.g. rgba(90,55,12,0.18)) — we discard
	// it and substitute s.opacity directly, matching the original behaviour.
	// Fallback matches the late-summer rule token.
	function extractRGB() {
		const raw   = getComputedStyle( group )
			.getPropertyValue( '--wp--preset--color--rule' )
			.trim() || 'rgba(90,55,12,0.22)';
		const match = raw.match( /[\d.]+/g );

		return ( match && match.length >= 3 )
			? `${ match[ 0 ] },${ match[ 1 ] },${ match[ 2 ] }`
			: '90,55,12';
	}

	rgb = extractRGB();

	// ─── DRAW ────────────────────────────────────────────────────────────────

	function draw( t ) {
		buildField( t );
		ctx.clearRect( 0, 0, window.innerWidth, window.innerHeight );
		ctx.lineWidth = CONFIG.lineWidth;

		for ( const s of seeds ) {
			let x = s.x;
			let y = s.y;

			ctx.strokeStyle = `rgba(${ rgb },${ s.opacity })`;
			ctx.beginPath();
			ctx.moveTo( x, y );

			for ( let i = 0; i < s.segments; i++ ) {
				const a = getAngle( x, y );
				x += Math.cos( a ) * CONFIG.stepX;
				y += Math.sin( a ) * CONFIG.stepY;

				if ( x < -5 || x > window.innerWidth + 5 || y < -5 || y > window.innerHeight + 5 ) {
					break;
				}

				ctx.lineTo( x, y );
			}

			ctx.stroke();
		}
	}

	// ─── REDUCED MOTION — draw once at t=0, then stop ────────────────────────

	if ( reducedMotion ) {
		draw( 0 );
		return;
	}

	// ─── ANIMATION LOOP ──────────────────────────────────────────────────────

	let t     = 0;
	let rafId = null;

	function tick() {
		t    += CONFIG.driftSpeed;
		draw( t );
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
