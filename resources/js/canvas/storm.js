/**
 * Storm — rainfall and splash canvas effect.
 *
 * Renders animated rain drops falling at an angle with wind, plus ripple and
 * particle splashes when drops hit the bottom of the viewport. Rain colour is
 * hardcoded as a cool blue-grey — it represents actual water, not a palette
 * choice, so it does not derive from the style variation tokens.
 *
 * Canvas class  : x3p0-canvas-bg--storm
 * Position      : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized but never animated
 *
 * @file resources/js/canvas/storm.js
 */

( function () {

	const canvas = document.querySelector( '.x3p0-canvas-bg--storm' );

	if ( ! canvas ) {
		return;
	}

	const group = canvas.parentElement;
	const ctx   = canvas.getContext( '2d' );

	// ─── CONFIG ──────────────────────────────────────────────────────────────

	const CONFIG = {
		// Number of rain drops.
		count: 320,

		// Horizontal wind strength.
		windX: 3.5,

		// Base fall speed.
		speed: 25,

		// Overall canvas opacity (0–1).
		opacity: 0.65,

		// Drop length range (before layer scaling), in CSS px.
		dropLenMin: 8,
		dropLenMax: 18,

		// Drop speed range (before layer scaling).
		dropSpeedMin: 6,
		dropSpeedMax: 10,

		// Drop alpha range (before layer scaling).
		dropAlphaMin: 0.18,
		dropAlphaMax: 0.52,

		// Drop line width range (before layer scaling), in CSS px.
		dropWidthMin: 0.7,
		dropWidthMax: 1.3,

		// Rain colour (RGB components — alpha set per drop).
		rainR: 160,
		rainG: 195,
		rainB: 225,

		// Splash ripple alpha range (before layer scaling).
		splashAlphaMin: 0.28,
		splashAlphaMax: 0.42,

		// Splash ripple radius range (before layer scaling), in CSS px.
		splashRadiusMin: 2,
		splashRadiusMax: 4,

		// Splash particle count range.
		splashPartsMin: 5,
		splashPartsMax: 8,

		// Splash particle speed range, in CSS px.
		splashSpeedMin: 1,
		splashSpeedMax: 2,

		// Splash particle gravity per frame, in CSS px.
		splashGravity: 0.22,

		// Splash life decay per frame (fraction of full life).
		splashDecay: 0.055,
	};

	// ─── CANVAS SETUP ────────────────────────────────────────────────────────

	let drops    = [];
	let splashes = [];

	function resize() {
		const dpr     = window.devicePixelRatio || 1;
		canvas.width  = window.innerWidth  * dpr;
		canvas.height = window.innerHeight * dpr;
		initDrops();
	}

	resize();
	window.addEventListener( 'resize', resize );

	// ─── DATA ATTRIBUTE OVERRIDES ────────────────────────────────────────────

	( function () {
		const map = {
			count:          Number,
			windX:          Number,
			speed:          Number,
			opacity:        Number,
			dropLenMin:     Number,
			dropLenMax:     Number,
			dropSpeedMin:   Number,
			dropSpeedMax:   Number,
			dropAlphaMin:   Number,
			dropAlphaMax:   Number,
			dropWidthMin:   Number,
			dropWidthMax:   Number,
			rainR:          Number,
			rainG:          Number,
			rainB:          Number,
			splashAlphaMin: Number,
			splashAlphaMax: Number,
			splashRadiusMin: Number,
			splashRadiusMax: Number,
			splashPartsMin: Number,
			splashPartsMax: Number,
			splashSpeedMin: Number,
			splashSpeedMax: Number,
			splashGravity:  Number,
			splashDecay:    Number,
		};

		Object.keys( map ).forEach( ( key ) => {
			if ( canvas.dataset[ key ] !== undefined ) {
				CONFIG[ key ] = map[ key ]( canvas.dataset[ key ] );
			}
		} );
	} )();

	// ─── REDUCED MOTION ──────────────────────────────────────────────────────

	const reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// ─── DROPS AND SPLASHES ──────────────────────────────────────────────────

	function mkDrop() {
		const dpr   = window.devicePixelRatio || 1;
		const W     = canvas.width;
		const H     = canvas.height;
		const layer = Math.random();

		return {
			x:     Math.random() * W * 1.5 - W * 0.25,
			y:     -Math.random() * H,
			len:   ( CONFIG.dropLenMin + Math.random() * ( CONFIG.dropLenMax - CONFIG.dropLenMin ) ) * ( 0.4 + layer * 0.9 ) * dpr,
			speed: ( CONFIG.dropSpeedMin + Math.random() * ( CONFIG.dropSpeedMax - CONFIG.dropSpeedMin ) ) * ( 0.4 + layer * 0.9 ),
			alpha: CONFIG.dropAlphaMin + layer * CONFIG.dropAlphaMax,
			width: ( CONFIG.dropWidthMin + layer * CONFIG.dropWidthMax ) * dpr,
			layer,
		};
	}

	function initDrops() {
		drops = [];

		for ( let i = 0; i < CONFIG.count; i++ ) {
			const d = mkDrop();
			d.y     = Math.random() * canvas.height;
			drops.push( d );
		}
	}

	function spawnSplash( x, y, layer ) {
		const dpr   = window.devicePixelRatio || 1;
		const count = CONFIG.splashPartsMin + Math.floor( Math.random() * ( CONFIG.splashPartsMax - CONFIG.splashPartsMin ) );
		const parts = [];

		for ( let i = 0; i < count; i++ ) {
			const a = -Math.PI + Math.random() * Math.PI;
			const s = ( CONFIG.splashSpeedMin + Math.random() * ( CONFIG.splashSpeedMax - CONFIG.splashSpeedMin ) ) * dpr;
			parts.push( {
				vx: Math.cos( a ) * s,
				vy: Math.sin( a ) * s - 2.5 * dpr,
				x,
				y,
			} );
		}

		splashes.push( {
			x,
			y,
			r:     ( CONFIG.splashRadiusMin + Math.random() * ( CONFIG.splashRadiusMax - CONFIG.splashRadiusMin ) ) * ( 0.4 + layer * 0.8 ) * dpr,
			parts,
			life:  1,
			alpha: CONFIG.splashAlphaMin + layer * CONFIG.splashAlphaMax,
		} );
	}

	// ─── DRAW ────────────────────────────────────────────────────────────────

	function rainColor( alpha ) {
		return `rgba(${ CONFIG.rainR },${ CONFIG.rainG },${ CONFIG.rainB },${ alpha })`;
	}

	function draw() {
		const dpr       = window.devicePixelRatio || 1;
		const W         = canvas.width;
		const H         = canvas.height;
		const speedMult = CONFIG.speed / 15;

		ctx.clearRect( 0, 0, W, H );
		ctx.globalAlpha = CONFIG.opacity;

		// Drops
		for ( let i = 0; i < drops.length; i++ ) {
			const d  = drops[ i ];
			const vx = CONFIG.windX * ( 0.3 + d.layer * 0.9 ) * speedMult;
			const vy = d.speed * speedMult;

			d.x += vx;
			d.y += vy;

			const tx   = d.x - ( vx / vy ) * d.len;
			const ty   = d.y - d.len;
			const grad = ctx.createLinearGradient( tx, ty, d.x, d.y );

			grad.addColorStop( 0, rainColor( 0 ) );
			grad.addColorStop( 1, rainColor( d.alpha ) );

			ctx.beginPath();
			ctx.moveTo( tx, ty );
			ctx.lineTo( d.x, d.y );
			ctx.strokeStyle = grad;
			ctx.lineWidth   = d.width;
			ctx.stroke();

			if ( d.y > H + d.len ) {
				spawnSplash( d.x, H - dpr, d.layer );
				drops[ i ] = mkDrop();
			} else if ( d.x > W * 1.3 || d.x < -W * 0.3 ) {
				drops[ i ] = mkDrop();
			}
		}

		// Splashes
		for ( let si = splashes.length - 1; si >= 0; si-- ) {
			const sp = splashes[ si ];
			sp.life -= CONFIG.splashDecay;

			if ( sp.life <= 0 ) {
				splashes.splice( si, 1 );
				continue;
			}

			ctx.beginPath();
			ctx.arc( sp.x, sp.y, sp.r * ( 1 + ( 1 - sp.life ) * 0.6 ), 0, Math.PI * 2 );
			ctx.strokeStyle = rainColor( sp.alpha * sp.life );
			ctx.lineWidth   = 0.8 * dpr;
			ctx.stroke();

			for ( const p of sp.parts ) {
				p.x  += p.vx;
				p.y  += p.vy;
				p.vy += CONFIG.splashGravity * dpr;

				if ( p.y < H ) {
					ctx.beginPath();
					ctx.arc( p.x, p.y, dpr, 0, Math.PI * 2 );
					ctx.fillStyle = rainColor( sp.alpha * sp.life * 0.5 );
					ctx.fill();
				}
			}
		}

		ctx.globalAlpha = 1;
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
