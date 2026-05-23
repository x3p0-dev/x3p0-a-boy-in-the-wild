/**
 * Snow and embers — atmospheric canvas effect.
 *
 * Snow particles fall from above (cool blue-white). Embers rise from a fixed
 * origin point in the lower-right area of the canvas (warm amber). Two
 * particle pools, one canvas. Used for Chapter 5 — How to Make a Fire When
 * Everything Is Wet.
 *
 * Canvas class  : x3p0-canvas-bg--snow-embers
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized but never animated
 *
 * @file resources/js/canvas/snow-embers.js
 */

( function () {

	const canvas = document.querySelector( '.x3p0-canvas-bg--snow-embers' );

	if ( ! canvas ) {
		return;
	}

	const group = canvas.parentElement;
	const ctx   = canvas.getContext( '2d' );

	// ─── CONFIG ──────────────────────────────────────────────────────────────

	const CONFIG = {
		// Snow particle count.
		snowCount: 60,

		// Snow particle radius range (CSS px, before scale).
		snowRadiusMin: 0.4,
		snowRadiusMax: 1.8,

		// Snow fall speed range (CSS px/frame).
		snowSpeedMin: 0.15,
		snowSpeedMax: 0.55,

		// Snow horizontal drift range (CSS px/frame).
		snowDriftRange: 0.3,

		// Snow opacity range.
		snowOpacityMin: 0.08,
		snowOpacityMax: 0.41,

		// Snow flicker amplitude (added/subtracted from opacity each frame).
		snowFlickerAmp: 0.06,

		// Snow oscillation speed (radians/frame multiplier).
		snowOscSpeed: 0.008,

		// Snow oscillation amplitude (CSS px).
		snowOscAmp: 0.15,

		// Snow colour (RGB components).
		snowR: 200,
		snowG: 210,
		snowB: 220,

		// Ember particle count.
		emberCount: 18,

		// Ember origin as a fraction of canvas dimensions.
		emberOriginX: 0.84,
		emberOriginY: 0.84,

		// Ember origin scatter radius (CSS px).
		emberScatterX: 80,
		emberScatterY: 40,

		// Ember particle radius range (CSS px, before scale).
		emberRadiusMin: 0.6,
		emberRadiusMax: 2.4,

		// Ember glow halo radius addition (CSS px, before scale).
		emberGlowRadius: 1.5,

		// Ember rise speed range (CSS px/frame).
		emberSpeedMin: 0.2,
		emberSpeedMax: 0.7,

		// Ember horizontal drift range (CSS px/frame).
		emberDriftRange: 0.4,

		// Ember opacity range.
		emberOpacityMin: 0.15,
		emberOpacityMax: 0.60,

		// Ember opacity fade per frame.
		emberFade: 0.0008,

		// Ember flicker amplitude.
		emberFlickerAmp: 0.08,

		// Ember oscillation speed (radians/frame multiplier).
		emberOscSpeed: 0.015,

		// Ember oscillation amplitude (CSS px).
		emberOscAmp: 0.3,

		// Ember hue range — added to base orange channel values.
		emberHueMin: 15,
		emberHueMax: 45,

		// Scale formula — particle sizes are multiplied by this value.
		// Derived from viewport area relative to a 1440×900 reference.
		// Override via data-scale to set a fixed value.
		scaleAuto: true,

		// Fixed scale value used when scaleAuto is false.
		scale: 1,
	};

	// ─── CANVAS SETUP ────────────────────────────────────────────────────────

	function resize() {
		const dpr     = window.devicePixelRatio || 1;
		canvas.width  = window.innerWidth  * dpr;
		canvas.height = window.innerHeight * dpr;
		ctx.scale( dpr, dpr );
	}

	resize();
	window.addEventListener( 'resize', resize );

	// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────

	( function () {
		const map = {
			snowCount:      Number,
			snowRadiusMin:  Number,
			snowRadiusMax:  Number,
			snowSpeedMin:   Number,
			snowSpeedMax:   Number,
			snowDriftRange: Number,
			snowOpacityMin: Number,
			snowOpacityMax: Number,
			snowFlickerAmp: Number,
			snowOscSpeed:   Number,
			snowOscAmp:     Number,
			snowR:          Number,
			snowG:          Number,
			snowB:          Number,
			emberCount:     Number,
			emberOriginX:   Number,
			emberOriginY:   Number,
			emberScatterX:  Number,
			emberScatterY:  Number,
			emberRadiusMin: Number,
			emberRadiusMax: Number,
			emberGlowRadius: Number,
			emberSpeedMin:  Number,
			emberSpeedMax:  Number,
			emberDriftRange: Number,
			emberOpacityMin: Number,
			emberOpacityMax: Number,
			emberFade:      Number,
			emberFlickerAmp: Number,
			emberOscSpeed:  Number,
			emberOscAmp:    Number,
			emberHueMin:    Number,
			emberHueMax:    Number,
			scale:          Number,
		};

		Object.keys( map ).forEach( ( key ) => {
			if ( canvas.dataset[ key ] !== undefined ) {
				CONFIG[ key ] = map[ key ]( canvas.dataset[ key ] );

				// If scale is explicitly set, disable auto scaling.
				if ( key === 'scale' ) {
					CONFIG.scaleAuto = false;
				}
			}
		} );
	} )();

	// ─── REDUCED MOTION ──────────────────────────────────────────────────────

	const reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// ─── SCALE ───────────────────────────────────────────────────────────────

	function getScale() {
		if ( ! CONFIG.scaleAuto ) {
			return CONFIG.scale;
		}

		return Math.max(
			0.4,
			Math.min(
				2.5,
				Math.sqrt( ( window.innerWidth * window.innerHeight ) / ( 1440 * 900 ) )
			)
		);
	}

	// ─── PARTICLES ───────────────────────────────────────────────────────────

	function emberOrigin() {
		return {
			x: window.innerWidth  * CONFIG.emberOriginX,
			y: window.innerHeight * CONFIG.emberOriginY,
		};
	}

	const snow = Array.from( { length: CONFIG.snowCount }, () => ( {
		x:       Math.random() * window.innerWidth,
		y:       Math.random() * window.innerHeight,
		r:       CONFIG.snowRadiusMin + Math.random() * ( CONFIG.snowRadiusMax - CONFIG.snowRadiusMin ),
		speed:   CONFIG.snowSpeedMin  + Math.random() * ( CONFIG.snowSpeedMax  - CONFIG.snowSpeedMin ),
		drift:   ( Math.random() - 0.5 ) * CONFIG.snowDriftRange,
		opacity: CONFIG.snowOpacityMin + Math.random() * ( CONFIG.snowOpacityMax - CONFIG.snowOpacityMin ),
		phase:   Math.random() * Math.PI * 2,
	} ) );

	const embers = Array.from( { length: CONFIG.emberCount }, () => {
		const o = emberOrigin();
		return {
			x:       o.x + ( Math.random() - 0.5 ) * CONFIG.emberScatterX,
			y:       o.y + Math.random() * CONFIG.emberScatterY,
			r:       CONFIG.emberRadiusMin + Math.random() * ( CONFIG.emberRadiusMax - CONFIG.emberRadiusMin ),
			speed:   CONFIG.emberSpeedMin  + Math.random() * ( CONFIG.emberSpeedMax  - CONFIG.emberSpeedMin ),
			drift:   ( Math.random() - 0.5 ) * CONFIG.emberDriftRange,
			opacity: CONFIG.emberOpacityMin + Math.random() * ( CONFIG.emberOpacityMax - CONFIG.emberOpacityMin ),
			phase:   Math.random() * Math.PI * 2,
			hue:     CONFIG.emberHueMin + Math.random() * ( CONFIG.emberHueMax - CONFIG.emberHueMin ),
		};
	} );

	// ─── DRAW ────────────────────────────────────────────────────────────────

	let frame = 0;

	function draw() {
		const scale = getScale();
		const W     = window.innerWidth;
		const H     = window.innerHeight;

		ctx.clearRect( 0, 0, W, H );

		// Snow
		for ( const s of snow ) {
			s.y += s.speed;
			s.x += s.drift + Math.sin( frame * CONFIG.snowOscSpeed + s.phase ) * CONFIG.snowOscAmp;

			if ( s.y > H + 10 ) { s.y = -10; s.x = Math.random() * W; }
			if ( s.x < -10 )    { s.x = W + 10; }
			if ( s.x > W + 10 ) { s.x = -10; }

			const flicker = Math.sin( frame * 0.04 + s.phase ) * CONFIG.snowFlickerAmp;

			ctx.beginPath();
			ctx.arc( s.x, s.y, s.r * scale, 0, Math.PI * 2 );
			ctx.fillStyle = `rgba(${ CONFIG.snowR },${ CONFIG.snowG },${ CONFIG.snowB },${ s.opacity + flicker })`;
			ctx.fill();
		}

		// Embers
		for ( const e of embers ) {
			e.y       -= e.speed;
			e.x       += e.drift + Math.sin( frame * CONFIG.emberOscSpeed + e.phase ) * CONFIG.emberOscAmp;
			e.opacity -= CONFIG.emberFade;

			if ( e.y < -10 || e.opacity <= 0 ) {
				const o   = emberOrigin();
				e.y       = o.y + Math.random() * CONFIG.emberScatterY;
				e.x       = o.x + ( Math.random() - 0.5 ) * CONFIG.emberScatterX;
				e.opacity = CONFIG.emberOpacityMin + Math.random() * ( CONFIG.emberOpacityMax - CONFIG.emberOpacityMin );
				e.speed   = CONFIG.emberSpeedMin   + Math.random() * ( CONFIG.emberSpeedMax   - CONFIG.emberSpeedMin );
				e.drift   = ( Math.random() - 0.5 ) * CONFIG.emberDriftRange;
				e.hue     = CONFIG.emberHueMin + Math.random() * ( CONFIG.emberHueMax - CONFIG.emberHueMin );
			}

			const flicker = Math.sin( frame * CONFIG.emberOscSpeed + e.phase ) * CONFIG.emberFlickerAmp;

			// Glow halo
			ctx.beginPath();
			ctx.arc( e.x, e.y, ( e.r + CONFIG.emberGlowRadius ) * scale, 0, Math.PI * 2 );
			ctx.fillStyle = `rgba(255,${ 120 + e.hue },20,${ e.opacity * 0.5 })`;
			ctx.fill();

			// Core
			ctx.beginPath();
			ctx.arc( e.x, e.y, e.r * scale, 0, Math.PI * 2 );
			ctx.fillStyle = `rgba(255,${ 180 + e.hue },80,${ e.opacity + flicker })`;
			ctx.fill();
		}

		frame++;
	}

	// ─── REDUCED MOTION — canvas sized but never animated ────────────────────

	if ( reducedMotion ) {
		return;
	}

	// ─── ANIMATION LOOP ──────────────────────────────────────────────────────

	let rafId = null;

	function tick() {
		draw();
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
