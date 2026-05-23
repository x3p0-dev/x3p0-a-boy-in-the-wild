/**
 * Canvas effect: Moonlight — 404 Lost page.
 *
 * Renders the full moonlight scene: a moon disc sitting just above the top
 * edge of the viewport, two static halo rings, a volumetric beam shaft
 * falling through the forest gap, and two soft ground pools of reflected
 * light. The moon bloom pulses very slowly — not flickering, just breathing,
 * the way moonlight feels when your eyes have adjusted and the forest seems
 * to shift without anything actually moving. The beam has an extremely subtle
 * cold-air shimmer. Nothing here is dramatic. It is simply the moon, and the
 * light it makes.
 *
 * Canvas class : x3p0-canvas-scene--lost-moon
 * Position     : fixed — fills the viewport regardless of scroll
 * Reduced motion: canvas is sized, drawn once at mid-pulse, then static
 *
 * @file resources/js/canvas/chapter-lost-moon.js
 */

( function () {

	const canvas = document.querySelector( '.x3p0-canvas-scene--lost-moon' );

	if ( ! canvas ) {
		return;
	}

	const group = canvas.parentElement;
	const ctx   = canvas.getContext( '2d' );

	// ─── CONFIG ──────────────────────────────────────────────────────────────

	const CONFIG = {
		// Moon centre X as a fraction of viewport width.
		moonX: 0.5,

		// Moon centre Y as a fraction of viewport height.
		// Negative keeps it partially above the top edge.
		moonY: -0.048,

		// Moon disc radius as a fraction of viewport height.
		moonRadius: 0.098,

		// Halo ring radii as fractions of viewport height.
		haloRadius1: 0.168,
		haloRadius2: 0.215,

		// Halo ring opacities — static, no animation.
		haloOpacity1: 0.07,
		haloOpacity2: 0.045,

		// Moon bloom pulse — opacity range for the outer glow.
		// Very close values so the pulse is barely perceptible.
		bloomOpacityMin: 0.055,
		bloomOpacityMax: 0.095,

		// Bloom radius as a fraction of viewport height.
		bloomRadius: 0.62,

		// Bloom pulse duration (ms) — one full cycle.
		bloomPulseDuration: 10000,

		// Beam shaft — wide cone from moon to ground.
		// Width at base as a fraction of viewport width.
		beamWidthBase: 0.28,

		// Beam shaft — narrow top width as a fraction of viewport width.
		beamWidthTop: 0.06,

		// Beam opacity range for cold-air shimmer.
		beamOpacityMin: 0.038,
		beamOpacityMax: 0.065,

		// Beam shimmer duration (ms) — one full cycle.
		beamShimmerDuration: 7500,

		// Inner beam — tighter, more luminous core.
		innerBeamWidthBase: 0.14,
		innerBeamWidthTop:  0.032,
		innerBeamOpacity:   0.048,

		// Ground pool — centre, directly under beam.
		poolCentreRadius: 0.32,
		poolCentreOpacity: 0.088,

		// Ground pool — left and right secondary pools.
		poolSideRadius:   0.22,
		poolSideOpacity:  0.055,
		poolLeftX:        0.26,
		poolRightX:       0.74,
		poolY:            0.88,
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
			moonX:                Number,
			moonY:                Number,
			moonRadius:           Number,
			haloRadius1:          Number,
			haloRadius2:          Number,
			haloOpacity1:         Number,
			haloOpacity2:         Number,
			bloomOpacityMin:      Number,
			bloomOpacityMax:      Number,
			bloomRadius:          Number,
			bloomPulseDuration:   Number,
			beamWidthBase:        Number,
			beamWidthTop:         Number,
			beamOpacityMin:       Number,
			beamOpacityMax:       Number,
			beamShimmerDuration:  Number,
			innerBeamWidthBase:   Number,
			innerBeamWidthTop:    Number,
			innerBeamOpacity:     Number,
			poolCentreRadius:     Number,
			poolCentreOpacity:    Number,
			poolSideRadius:       Number,
			poolSideOpacity:      Number,
			poolLeftX:            Number,
			poolRightX:           Number,
			poolY:                Number,
		};

		Object.keys( map ).forEach( ( key ) => {
			if ( canvas.dataset[ key ] !== undefined ) {
				CONFIG[ key ] = map[ key ]( canvas.dataset[ key ] );
			}
		} );
	} )();

	// ─── REDUCED MOTION ──────────────────────────────────────────────────────

	const reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

	// ─── COLOUR ──────────────────────────────────────────────────────────────

	// ink-accent — moonbeam amber-silver. Used for beam, pools, bloom.
	// Fallback: late-summer ink-accent.
	const style        = getComputedStyle( group );
	const inkAccent    = style.getPropertyValue( '--wp--preset--color--ink-accent' ).trim()
		|| '#4a2808';

	// parchment-accent — secondary moon colour. Used for disc gradient.
	// Fallback: late-summer parchment-accent.
	const parchAccent  = style.getPropertyValue( '--wp--preset--color--parchment-accent' ).trim()
		|| '#9a5818';

	// ─── DRAW ─────────────────────────────────────────────────────────────────

	function drawFrame( bloomAlpha, beamAlpha ) {
		const W  = canvas.width;
		const H  = canvas.height;
		const MX = CONFIG.moonX * W;
		const MY = CONFIG.moonY * H;
		const MR = CONFIG.moonRadius * H;

		ctx.clearRect( 0, 0, W, H );

		// ── Bloom — outer atmospheric glow, animated ──────────────────────────
		const bloomR  = CONFIG.bloomRadius * H;
		const bloom   = ctx.createRadialGradient( MX, MY, 0, MX, MY, bloomR );
		bloom.addColorStop( 0,    inkAccent );
		bloom.addColorStop( 0.25, inkAccent );
		bloom.addColorStop( 1,    'transparent' );

		ctx.globalAlpha = bloomAlpha;
		ctx.fillStyle   = bloom;
		ctx.fillRect( 0, 0, W, H );

		// ── Halo rings — static ───────────────────────────────────────────────
		ctx.globalAlpha = CONFIG.haloOpacity1;
		ctx.strokeStyle = inkAccent;
		ctx.lineWidth   = 1.5;
		ctx.beginPath();
		ctx.arc( MX, MY, CONFIG.haloRadius1 * H, 0, Math.PI * 2 );
		ctx.stroke();

		ctx.globalAlpha = CONFIG.haloOpacity2;
		ctx.lineWidth   = 1;
		ctx.beginPath();
		ctx.arc( MX, MY, CONFIG.haloRadius2 * H, 0, Math.PI * 2 );
		ctx.stroke();

		// ── Beam shaft — wide cone, animated shimmer ──────────────────────────
		const beamBase = ( CONFIG.beamWidthBase / 2 ) * W;
		const beamTop  = ( CONFIG.beamWidthTop  / 2 ) * W;
		const beamGrad = ctx.createLinearGradient( MX, 0, MX, H );
		beamGrad.addColorStop( 0,    inkAccent );
		beamGrad.addColorStop( 0.22, inkAccent );
		beamGrad.addColorStop( 0.62, inkAccent );
		beamGrad.addColorStop( 1,    'transparent' );

		ctx.globalAlpha = beamAlpha;
		ctx.fillStyle   = beamGrad;
		ctx.beginPath();
		ctx.moveTo( MX - beamTop,  0 );
		ctx.lineTo( MX - beamBase, H );
		ctx.lineTo( MX + beamBase, H );
		ctx.lineTo( MX + beamTop,  0 );
		ctx.closePath();
		ctx.fill();

		// ── Inner beam — tighter luminous core, static opacity ────────────────
		const innerBase = ( CONFIG.innerBeamWidthBase / 2 ) * W;
		const innerTop  = ( CONFIG.innerBeamWidthTop  / 2 ) * W;
		const innerGrad = ctx.createLinearGradient( MX, 0, MX, H * 0.72 );
		innerGrad.addColorStop( 0,   inkAccent );
		innerGrad.addColorStop( 0.5, inkAccent );
		innerGrad.addColorStop( 1,   'transparent' );

		ctx.globalAlpha = CONFIG.innerBeamOpacity;
		ctx.fillStyle   = innerGrad;
		ctx.beginPath();
		ctx.moveTo( MX - innerTop,  0 );
		ctx.lineTo( MX - innerBase, H * 0.72 );
		ctx.lineTo( MX + innerBase, H * 0.72 );
		ctx.lineTo( MX + innerTop,  0 );
		ctx.closePath();
		ctx.fill();

		// ── Ground pools — soft reflected light ───────────────────────────────

		// Centre pool
		const poolCR   = CONFIG.poolCentreRadius * W;
		const poolCGrad = ctx.createRadialGradient( MX, H, 0, MX, H, poolCR );
		poolCGrad.addColorStop( 0,   inkAccent );
		poolCGrad.addColorStop( 0.5, inkAccent );
		poolCGrad.addColorStop( 1,   'transparent' );

		ctx.globalAlpha = CONFIG.poolCentreOpacity;
		ctx.fillStyle   = poolCGrad;
		ctx.fillRect( 0, 0, W, H );

		// Left pool
		const poolSR    = CONFIG.poolSideRadius * W;
		const poolLX    = CONFIG.poolLeftX  * W;
		const poolRX    = CONFIG.poolRightX * W;
		const poolY     = CONFIG.poolY      * H;

		const poolLGrad = ctx.createRadialGradient( poolLX, poolY, 0, poolLX, poolY, poolSR );
		poolLGrad.addColorStop( 0,   inkAccent );
		poolLGrad.addColorStop( 0.5, inkAccent );
		poolLGrad.addColorStop( 1,   'transparent' );

		ctx.globalAlpha = CONFIG.poolSideOpacity;
		ctx.fillStyle   = poolLGrad;
		ctx.fillRect( 0, 0, W, H );

		// Right pool
		const poolRGrad = ctx.createRadialGradient( poolRX, poolY, 0, poolRX, poolY, poolSR );
		poolRGrad.addColorStop( 0,   inkAccent );
		poolRGrad.addColorStop( 0.5, inkAccent );
		poolRGrad.addColorStop( 1,   'transparent' );

		ctx.globalAlpha = CONFIG.poolSideOpacity;
		ctx.fillStyle   = poolRGrad;
		ctx.fillRect( 0, 0, W, H );

		// ── Moon disc — drawn last so it sits above the bloom ─────────────────
		const moonGrad = ctx.createRadialGradient( MX, MY - MR * 0.15, 0, MX, MY, MR );
		moonGrad.addColorStop( 0,   '#faf5e0' );
		moonGrad.addColorStop( 0.5, '#f0e8c0' );
		moonGrad.addColorStop( 0.8, '#e4d898' );
		moonGrad.addColorStop( 1,   parchAccent );

		ctx.globalAlpha = 0.92;
		ctx.fillStyle   = moonGrad;
		ctx.beginPath();
		ctx.arc( MX, MY, MR, 0, Math.PI * 2 );
		ctx.fill();

		// Very subtle crater texture
		ctx.globalAlpha = 0.055;
		ctx.fillStyle   = parchAccent;
		ctx.beginPath();
		ctx.arc( MX - MR * 0.27, MY - MR * 0.20, MR * 0.20, 0, Math.PI * 2 );
		ctx.fill();
		ctx.beginPath();
		ctx.arc( MX + MR * 0.37, MY + MR * 0.13, MR * 0.13, 0, Math.PI * 2 );
		ctx.fill();
		ctx.beginPath();
		ctx.arc( MX - MR * 0.09, MY + MR * 0.30, MR * 0.16, 0, Math.PI * 2 );
		ctx.fill();

		ctx.globalAlpha = 1;
	}

	// ─── REDUCED MOTION — draw once at mid-pulse ─────────────────────────────

	if ( reducedMotion ) {
		const midBloom = ( CONFIG.bloomOpacityMin + CONFIG.bloomOpacityMax ) / 2;
		const midBeam  = ( CONFIG.beamOpacityMin  + CONFIG.beamOpacityMax  ) / 2;
		drawFrame( midBloom, midBeam );
		return;
	}

	// ─── ANIMATION LOOP ───────────────────────────────────────────────────────

	let rafId = null;

	function tick( timestamp ) {
		// Bloom pulse — slow sine wave between min and max opacity.
		const bloomPhase = ( timestamp % CONFIG.bloomPulseDuration ) / CONFIG.bloomPulseDuration;
		const bloomAlpha = CONFIG.bloomOpacityMin
			+ ( CONFIG.bloomOpacityMax - CONFIG.bloomOpacityMin )
			* ( 0.5 + 0.5 * Math.sin( bloomPhase * Math.PI * 2 ) );

		// Beam shimmer — independent cycle, offset phase so it doesn't
		// sync with the bloom pulse.
		const beamPhase  = ( timestamp % CONFIG.beamShimmerDuration ) / CONFIG.beamShimmerDuration;
		const beamAlpha  = CONFIG.beamOpacityMin
			+ ( CONFIG.beamOpacityMax - CONFIG.beamOpacityMin )
			* ( 0.5 + 0.5 * Math.sin( beamPhase * Math.PI * 2 + 1.2 ) );

		drawFrame( bloomAlpha, beamAlpha );
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
