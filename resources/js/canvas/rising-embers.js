/**
 * Rising Embers
 * Canvas effect — soft embers rising from the bottom of the viewport.
 *
 * Warm amber and orange particles with glow halos, drifting upward and fading
 * out. Colours derived from the style variation's CSS custom properties.
 *
 * Canvas class: .x3p0-canvas-bg--rising-embers
 * The canvas element is a direct child of the Entry Group block.
 * The group is canvas.parentElement.
 *
 * All CONFIG values can be overridden via data-* attributes on the canvas
 * element. Attribute names use kebab-case: data-ember-count, data-alpha-max,
 * etc. See the data attribute overrides section below.
 *
 * Respects prefers-reduced-motion — canvas is found but never animated
 * if the user has requested reduced motion.
 */

( function () {

	// ------------------------------------------------------------------ //
	// Config — adjust these values to tune the effect.
	// All values can be overridden via data-* attributes on the canvas.
	// ------------------------------------------------------------------ //

	const CONFIG = {

		// Number of ember particles.
		emberCount: 22,

		// Origin spread across the viewport width (0–1 fraction).
		// 0.0–1.0 = full width. 0.35–0.65 = centre third.
		originXMin: 0.00,
		originXMax: 1.00,

		// Origin vertical range — embers spawn near the bottom.
		originYMin: 0.80,
		originYMax: 1.00,

		// Rise speed range (px/frame, negative = upward).
		riseSpeedMin: -0.45,
		riseSpeedMax: -0.18,

		// Base horizontal drift range (px/frame).
		driftXMin: -0.20,
		driftXMax:  0.20,

		// Wobble — horizontal sine oscillation.
		wobbleSpeedMin: 0.006,
		wobbleSpeedMax: 0.022,
		wobbleAmpMin:   0.08,
		wobbleAmpMax:   0.45,

		// Particle radius range (px).
		radiusMin: 1.0,
		radiusMax: 2.6,

		// Glow halo size multiplier relative to radius.
		glowRadiusMultiplier: 4.5,

		// Opacity range — kept low for subtlety.
		alphaMin: 0.18,
		alphaMax: 0.48,

		// Fade rate range (alpha lost per frame).
		fadeRateMin: 0.0012,
		fadeRateMax: 0.0028,

		// Flicker — radius pulses slightly.
		flickerSpeedMin: 0.04,
		flickerSpeedMax: 0.10,
		flickerAmpMin:   0.12,
		flickerAmpMax:   0.32,

	};

	// ------------------------------------------------------------------ //
	// Canvas setup.
	// ------------------------------------------------------------------ //

	const canvas = document.querySelector( '.x3p0-canvas-bg--rising-embers' );

	if ( ! canvas ) {
		return;
	}

	const ctx   = canvas.getContext( '2d' );
	const group = canvas.parentElement;

	function resize() {
		canvas.width  = window.innerWidth;
		canvas.height = window.innerHeight;
	}

	resize();
	window.addEventListener( 'resize', resize );

	// ------------------------------------------------------------------ //
	// Data attribute overrides.
	// Merges data-* attributes from the canvas element into CONFIG.
	// Each key maps to its type constructor for explicit coercion.
	// ------------------------------------------------------------------ //

	( function () {
		const map = {
			emberCount:          Number,
			originXMin:          Number,
			originXMax:          Number,
			originYMin:          Number,
			originYMax:          Number,
			riseSpeedMin:        Number,
			riseSpeedMax:        Number,
			driftXMin:           Number,
			driftXMax:           Number,
			wobbleSpeedMin:      Number,
			wobbleSpeedMax:      Number,
			wobbleAmpMin:        Number,
			wobbleAmpMax:        Number,
			radiusMin:           Number,
			radiusMax:           Number,
			glowRadiusMultiplier: Number,
			alphaMin:            Number,
			alphaMax:            Number,
			fadeRateMin:         Number,
			fadeRateMax:         Number,
			flickerSpeedMin:     Number,
			flickerSpeedMax:     Number,
			flickerAmpMin:       Number,
			flickerAmpMax:       Number,
		};

		Object.keys( map ).forEach( ( key ) => {
			if ( canvas.dataset[ key ] !== undefined ) {
				CONFIG[ key ] = map[ key ]( canvas.dataset[ key ] );
			}
		} );
	} )();

	// ------------------------------------------------------------------ //
	// Reduced motion — do not animate.
	// ------------------------------------------------------------------ //

	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	// ------------------------------------------------------------------ //
	// Colour utilities.
	// ------------------------------------------------------------------ //

	function hexToRgb( hex ) {
		const clean = hex.replace( '#', '' );

		if ( clean.length === 3 ) {
			return {
				r: parseInt( clean[ 0 ] + clean[ 0 ], 16 ),
				g: parseInt( clean[ 1 ] + clean[ 1 ], 16 ),
				b: parseInt( clean[ 2 ] + clean[ 2 ], 16 ),
			};
		}

		if ( clean.length === 6 ) {
			return {
				r: parseInt( clean.slice( 0, 2 ), 16 ),
				g: parseInt( clean.slice( 2, 4 ), 16 ),
				b: parseInt( clean.slice( 4, 6 ), 16 ),
			};
		}

		return null;
	}

	function rgbToHsl( { r, g, b } ) {
		const rn    = r / 255;
		const gn    = g / 255;
		const bn    = b / 255;
		const max   = Math.max( rn, gn, bn );
		const min   = Math.min( rn, gn, bn );
		const delta = max - min;
		const l     = ( max + min ) / 2;

		if ( delta === 0 ) { return { h: 0, s: 0, l }; }

		const s = delta / ( 1 - Math.abs( 2 * l - 1 ) );
		let h;

		if      ( max === rn ) { h = ( ( gn - bn ) / delta ) % 6; }
		else if ( max === gn ) { h = ( bn - rn ) / delta + 2; }
		else                   { h = ( rn - gn ) / delta + 4; }

		return { h: ( h * 60 + 360 ) % 360, s, l };
	}

	function hslToRgba( { h, s, l }, alpha ) {
		const c = ( 1 - Math.abs( 2 * l - 1 ) ) * s;
		const x = c * ( 1 - Math.abs( ( h / 60 ) % 2 - 1 ) );
		const m = l - c / 2;
		let r, g, b;

		if      ( h <  60 ) { r = c; g = x; b = 0; }
		else if ( h < 120 ) { r = x; g = c; b = 0; }
		else if ( h < 180 ) { r = 0; g = c; b = x; }
		else if ( h < 240 ) { r = 0; g = x; b = c; }
		else if ( h < 300 ) { r = x; g = 0; b = c; }
		else                { r = c; g = 0; b = x; }

		return `rgba(${ Math.round( ( r + m ) * 255 ) }, ${ Math.round( ( g + m ) * 255 ) }, ${ Math.round( ( b + m ) * 255 ) }, ${ alpha.toFixed( 3 ) })`;
	}

	function buildEmberColours() {
		const style          = getComputedStyle( group );
		const rawInkAccent   = style.getPropertyValue( '--wp--preset--color--ink-accent' ).trim();
		const rawParchAccent = style.getPropertyValue( '--wp--preset--color--parchment-accent' ).trim();
		const inkAccentRgb   = hexToRgb( rawInkAccent );
		const parchAccentRgb = hexToRgb( rawParchAccent );

		if ( ! inkAccentRgb || ! parchAccentRgb ) {
			return [
				'rgba(255, 160,  60, {a})',
				'rgba(255, 130,  40, {a})',
				'rgba(255, 190,  80, {a})',
				'rgba(220, 110,  30, {a})',
				'rgba(255, 210, 100, {a})',
			];
		}

		const base = rgbToHsl( inkAccentRgb );
		const mid  = rgbToHsl( parchAccentRgb );
		const ph   = ( rgba ) => rgba.replace( /,[^,]+\)$/, ', {a})' );

		return [
			ph( hslToRgba( { h: base.h,      s: base.s,                        l: Math.min( base.l + 0.10, 0.75 ) }, 1 ) ),
			ph( hslToRgba( { h: mid.h,        s: mid.s,                         l: Math.min( mid.l  + 0.05, 0.75 ) }, 1 ) ),
			ph( hslToRgba( { h: base.h - 10,  s: Math.min( base.s + 0.10, 1 ), l: Math.min( base.l + 0.30, 0.85 ) }, 1 ) ),
			ph( hslToRgba( { h: base.h + 20,  s: Math.max( base.s - 0.10, 0 ), l: Math.min( base.l + 0.45, 0.92 ) }, 1 ) ),
			ph( hslToRgba( { h: base.h - 5,   s: Math.min( base.s + 0.05, 1 ), l: Math.min( base.l + 0.55, 0.96 ) }, 1 ) ),
		];
	}

	const COLOURS = buildEmberColours();

	// ------------------------------------------------------------------ //
	// Ember particle.
	// ------------------------------------------------------------------ //

	function randomBetween( min, max ) {
		return min + Math.random() * ( max - min );
	}

	function randomColour() {
		return COLOURS[ Math.floor( Math.random() * COLOURS.length ) ];
	}

	function createEmber() {
		const originX = canvas.width  * randomBetween( CONFIG.originXMin, CONFIG.originXMax );
		const originY = canvas.height * randomBetween( CONFIG.originYMin, CONFIG.originYMax );

		return {
			x:           originX,
			y:           originY,
			radius:      randomBetween( CONFIG.radiusMin,      CONFIG.radiusMax      ),
			vy:          randomBetween( CONFIG.riseSpeedMin,   CONFIG.riseSpeedMax   ),
			vx:          randomBetween( CONFIG.driftXMin,      CONFIG.driftXMax      ),
			wobble:      randomBetween( 0, Math.PI * 2 ),
			wobbleSpeed: randomBetween( CONFIG.wobbleSpeedMin, CONFIG.wobbleSpeedMax ),
			wobbleAmp:   randomBetween( CONFIG.wobbleAmpMin,   CONFIG.wobbleAmpMax   ),
			alpha:       randomBetween( CONFIG.alphaMin,       CONFIG.alphaMax       ),
			fadeRate:    randomBetween( CONFIG.fadeRateMin,    CONFIG.fadeRateMax    ),
			colour:      randomColour(),
			flicker:      randomBetween( 0, Math.PI * 2 ),
			flickerSpeed: randomBetween( CONFIG.flickerSpeedMin, CONFIG.flickerSpeedMax ),
			flickerAmp:   randomBetween( CONFIG.flickerAmpMin,   CONFIG.flickerAmpMax   ),
		};
	}

	// Initialise staggered across the viewport so the first frame isn't empty.
	const embers = Array.from( { length: CONFIG.emberCount }, () => {
		const e = createEmber();
		e.y     = canvas.height * randomBetween( 0.20, 1.00 );
		e.alpha = randomBetween( CONFIG.alphaMin * 0.3, CONFIG.alphaMax );
		return e;
	} );

	// ------------------------------------------------------------------ //
	// Draw.
	// ------------------------------------------------------------------ //

	function drawEmber( e ) {
		if ( e.alpha <= 0 ) { return; }

		const { x, y, radius, alpha, colour } = e;
		const glowRadius = radius * CONFIG.glowRadiusMultiplier;

		const glow = ctx.createRadialGradient( x, y, 0, x, y, glowRadius );
		glow.addColorStop( 0, colour.replace( '{a}', ( alpha * 0.35 ).toFixed( 3 ) ) );
		glow.addColorStop( 1, colour.replace( '{a}', '0' ) );

		ctx.beginPath();
		ctx.arc( x, y, glowRadius, 0, Math.PI * 2 );
		ctx.fillStyle = glow;
		ctx.fill();

		const core = ctx.createRadialGradient( x, y, 0, x, y, radius );
		core.addColorStop( 0,   colour.replace( '{a}', Math.min( alpha * 1.2, 1 ).toFixed( 3 ) ) );
		core.addColorStop( 0.6, colour.replace( '{a}', alpha.toFixed( 3 ) ) );
		core.addColorStop( 1,   colour.replace( '{a}', '0' ) );

		ctx.beginPath();
		ctx.arc( x, y, radius, 0, Math.PI * 2 );
		ctx.fillStyle = core;
		ctx.fill();
	}

	// ------------------------------------------------------------------ //
	// Animation loop.
	// ------------------------------------------------------------------ //

	let rafId;

	function tick() {
		ctx.clearRect( 0, 0, canvas.width, canvas.height );

		for ( let i = 0; i < embers.length; i++ ) {
			const e = embers[ i ];

			e.wobble  += e.wobbleSpeed;
			e.flicker += e.flickerSpeed;
			e.x       += e.vx + Math.sin( e.wobble ) * e.wobbleAmp;
			e.y       += e.vy;
			e.radius  += Math.sin( e.flicker ) * e.flickerAmp * 0.05;
			e.alpha   -= e.fadeRate;

			drawEmber( e );

			if ( e.alpha <= 0 || e.y < -20 ) {
				embers[ i ] = createEmber();
			}
		}

		rafId = requestAnimationFrame( tick );
	}

	rafId = requestAnimationFrame( tick );

	// ------------------------------------------------------------------ //
	// Clean up if the group is removed from the DOM.
	// ------------------------------------------------------------------ //

	const observer = new MutationObserver( () => {
		if ( ! document.contains( group ) ) {
			cancelAnimationFrame( rafId );
			window.removeEventListener( 'resize', resize );
			observer.disconnect();
		}
	} );

	observer.observe( document.body, { childList: true, subtree: true } );

} )();
