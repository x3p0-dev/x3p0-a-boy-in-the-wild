( function () {

	const canvas = document.querySelector( '.x3p0-canvas-bg--snow-embers' );
	const group = canvas.parentElement;

	if ( ! group ) return;

	canvas.setAttribute( 'aria-hidden', 'true' );
	canvas.style.cssText = 'position:fixed;top:0;left:0;width:100vw;height:100vh;pointer-events:none;z-index:1;';

	const groupStyle = getComputedStyle( group );

	if ( groupStyle.position === 'static' ) {
		group.style.position = 'relative';
	}

	//group.append( canvas );

	const ctx = canvas.getContext( '2d' );

	let scale = 1;

	function resize() {
		canvas.width  = window.innerWidth;
		canvas.height = window.innerHeight;
		scale = Math.max( 0.4, Math.min( 2.5, Math.sqrt( ( window.innerWidth * window.innerHeight ) / ( 1440 * 900 ) ) ) );
	}

	window.addEventListener( 'load', resize );
	window.addEventListener( 'resize', resize );

	const ro = new ResizeObserver( resize );
	ro.observe( group );

	resize();

	function emberOrigin() {
		return {
			x: window.innerWidth  * 0.84,
			y: window.innerHeight * 0.84,
		};
	}

	const snow = Array.from( { length: 60 }, () => ( {
		x:       Math.random() * window.innerWidth,
		y:       Math.random() * window.innerHeight,
		r:       Math.random() * 1.4 + 0.4,
		speed:   Math.random() * 0.4 + 0.15,
		drift:   ( Math.random() - 0.5 ) * 0.3,
		opacity: Math.random() * 0.33 + 0.08,
		phase:   Math.random() * Math.PI * 2,
	} ) );

	const embers = Array.from( { length: 18 }, () => {
		const o = emberOrigin();
		return {
			x:       o.x + ( Math.random() - 0.5 ) * 80,
			y:       o.y + Math.random() * 40,
			r:       Math.random() * 1.8 + 0.6,
			speed:   Math.random() * 0.5 + 0.2,
			drift:   ( Math.random() - 0.5 ) * 0.4,
			opacity: Math.random() * 0.45 + 0.15,
			phase:   Math.random() * Math.PI * 2,
			hue:     Math.random() * 30 + 15,
		};
	} );

	let frame = 0;

	function tick() {
		ctx.clearRect( 0, 0, canvas.width, canvas.height );
		frame++;

		for ( const s of snow ) {
			s.y += s.speed;
			s.x += s.drift + Math.sin( frame * 0.008 + s.phase ) * 0.15;

			if ( s.y > canvas.height + 10 ) { s.y = -10; s.x = Math.random() * canvas.width; }
			if ( s.x < -10 )                { s.x = canvas.width + 10; }
			if ( s.x > canvas.width + 10 )  { s.x = -10; }

			const flicker = Math.sin( frame * 0.04 + s.phase ) * 0.06;
			ctx.beginPath();
			ctx.arc( s.x, s.y, s.r * scale, 0, Math.PI * 2 );
			ctx.fillStyle = `rgba(200,210,220,${ s.opacity + flicker })`;
			ctx.fill();
		}

		for ( const e of embers ) {
			e.y       -= e.speed;
			e.x       += e.drift + Math.sin( frame * 0.015 + e.phase ) * 0.3;
			e.opacity -= 0.0008;

			if ( e.y < -10 || e.opacity <= 0 ) {
				const o = emberOrigin();
				e.y       = o.y + Math.random() * 40;
				e.x       = o.x + ( Math.random() - 0.5 ) * 80;
				e.opacity = Math.random() * 0.45 + 0.15;
				e.speed   = Math.random() * 0.5 + 0.2;
				e.drift   = ( Math.random() - 0.5 ) * 0.4;
				e.hue     = Math.random() * 30 + 15;
			}

			const flicker = Math.sin( frame * 0.06 + e.phase ) * 0.08;

			ctx.beginPath();
			ctx.arc( e.x, e.y, ( e.r + 1.5 ) * scale, 0, Math.PI * 2 );
			ctx.fillStyle = `rgba(255,${ 120 + e.hue },20,${ e.opacity * 0.5 })`;
			ctx.fill();

			ctx.beginPath();
			ctx.arc( e.x, e.y, e.r * scale, 0, Math.PI * 2 );
			ctx.fillStyle = `rgba(255,${ 180 + e.hue },80,${ e.opacity + flicker })`;
			ctx.fill();
		}

		requestAnimationFrame( tick );
	}

	if ( window.matchMedia( '(prefers-reduced-motion: no-preference)' ).matches ) {
		tick();
	}
} )();
