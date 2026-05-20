( function () {

	const CONFIG = {
		clusterCount:          9,
		particlesMin:          2,
		particlesMax:          4,
		speedMin:              0.22,
		speedMax:              0.50,
		vertDriftAmp:          0.08,
		particleRadiusMin:     0.4,
		particleRadiusMax:     3.8,
		particleRadiusSkew:    1.8,
		particleAlphaMin:      0.10,
		particleAlphaMax:      0.26,
		particleSpreadX:       14,
		particleSpreadY:       10,
		wobbleAmpMin:          1.2,
		wobbleAmpMax:          3.0,
		wobbleSpeedMin:        0.008,
		wobbleSpeedMax:        0.014,
		clusterWobbleSpeedMin: 0.012,
		clusterWobbleSpeedMax: 0.020,
	};

	const canvas = document.querySelector( '.x3p0-canvas-bg--adrift' );

	if ( ! canvas ) return;

	const group = canvas.parentElement;
	const ctx   = canvas.getContext( '2d' );

	function resize() {
		canvas.width  = window.innerWidth;
		canvas.height = window.innerHeight;
	}

	resize();
	window.addEventListener( 'resize', resize );

	( function () {
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

	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	const style  = getComputedStyle( group );
	const colors = [
		( style.getPropertyValue( '--wp--preset--color--ink-accent'      ).trim() || 'rgba(100,62,12,1)'  ),
		( style.getPropertyValue( '--wp--preset--color--ink-subtle'      ).trim() || 'rgba(80,48,10,1)'   ),
		( style.getPropertyValue( '--wp--preset--color--ink-muted'       ).trim() || 'rgba(60,36,8,1)'    ),
		( style.getPropertyValue( '--wp--preset--color--parchment-accent').trim() || 'rgba(120,75,18,1)'  ),
	];

	function makeCluster( randomX ) {
		const W = canvas.width;
		const H = canvas.height;
		const n = CONFIG.particlesMin + Math.floor( Math.random() * ( CONFIG.particlesMax - CONFIG.particlesMin + 1 ) );

		const particles = [];

		for ( let i = 0; i < n; i++ ) {
			particles.push( {
				ox:           ( Math.random() - 0.5 ) * CONFIG.particleSpreadX,
				oy:           ( Math.random() - 0.5 ) * CONFIG.particleSpreadY,
				r:            CONFIG.particleRadiusMin + Math.pow( Math.random(), CONFIG.particleRadiusSkew ) * ( CONFIG.particleRadiusMax - CONFIG.particleRadiusMin ),
				alpha:        CONFIG.particleAlphaMin  + Math.random() * ( CONFIG.particleAlphaMax  - CONFIG.particleAlphaMin ),
				wobbleOffset: Math.random() * Math.PI * 2,
				wobbleSpeed:  CONFIG.wobbleSpeedMin + Math.random() * ( CONFIG.wobbleSpeedMax - CONFIG.wobbleSpeedMin ),
				wobbleAmp:    CONFIG.wobbleAmpMin   + Math.random() * ( CONFIG.wobbleAmpMax   - CONFIG.wobbleAmpMin ),
				colorIndex:   Math.floor( Math.random() * colors.length ),
			} );
		}

		return {
			cx:           randomX ? Math.random() * W : -16,
			cy:           15 + Math.random() * ( H - 30 ),
			vx:           CONFIG.speedMin + Math.random() * ( CONFIG.speedMax - CONFIG.speedMin ),
			vy:           ( Math.random() - 0.5 ) * CONFIG.vertDriftAmp,
			wobbleOffset: Math.random() * Math.PI * 2,
			wobbleSpeed:  CONFIG.clusterWobbleSpeedMin + Math.random() * ( CONFIG.clusterWobbleSpeedMax - CONFIG.clusterWobbleSpeedMin ),
			particles,
		};
	}

	const clusters = [];

	for ( let i = 0; i < CONFIG.clusterCount; i++ ) {
		clusters.push( makeCluster( true ) );
	}

	let t   = 0;
	let raf = null;

	function tick() {
		const W = canvas.width;
		const H = canvas.height;

		ctx.clearRect( 0, 0, W, H );
		t++;

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
				const px = c.cx + p.ox + Math.sin( t * p.wobbleSpeed         + p.wobbleOffset ) * p.wobbleAmp;
				const py = c.cy + p.oy + Math.cos( t * p.wobbleSpeed * 0.7   + p.wobbleOffset ) * p.wobbleAmp * 0.5;

				ctx.beginPath();
				ctx.arc( px, py, p.r, 0, Math.PI * 2 );
				ctx.globalAlpha = p.alpha;
				ctx.fillStyle   = colors[ p.colorIndex ];
				ctx.fill();
				ctx.globalAlpha = 1;
			} );
		}

		raf = requestAnimationFrame( tick );
	}

	raf = requestAnimationFrame( tick );

	const observer = new MutationObserver( () => {
		if ( ! document.contains( group ) ) {
			cancelAnimationFrame( raf );
			window.removeEventListener( 'resize', resize );
			observer.disconnect();
		}
	} );

	observer.observe( document.body, { childList: true, subtree: true } );

} )();
