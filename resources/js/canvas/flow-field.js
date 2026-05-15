( () => {
	const canvas = document.querySelector( '.x3p0-canvas-bg--flow-field' );
	const group  = canvas.parentElement;
	const ctx    = canvas.getContext( '2d' );

	function resize() {
		canvas.width  = group.offsetWidth;
		canvas.height = group.scrollHeight;
	}

	window.addEventListener( 'load',   resize );
	window.addEventListener( 'resize', resize );
	resize();

	const LINE_COUNT = 300;
	const COLS       = 120;
	const ROWS       = 60;

	function noise( x, y, t ) {
		return (
			Math.sin( y * 0.8 + x * 0.15 + t * 0.5  ) * 0.60 +
			Math.sin( y * 1.8 + x * 0.25 + t * 0.35 ) * 0.25 +
			Math.sin( y * 3.2 + x * 0.1  + t * 0.2  ) * 0.10 +
			Math.sin( x * 0.5 + t * 0.15             ) * 0.05
		);
	}

	const field = [];

	function buildField( t ) {
		for ( let r = 0; r <= ROWS; r++ ) {
			if ( ! field[ r ] ) field[ r ] = [];
			for ( let c = 0; c <= COLS; c++ ) {
				field[ r ][ c ] = noise( c / COLS * 2.5, r / ROWS * 2, t ) * Math.PI;
			}
		}
	}

	function getAngle( x, y ) {
		const c = Math.min( Math.max( Math.floor( x / canvas.width  * COLS ), 0 ), COLS - 1 );
		const r = Math.min( Math.max( Math.floor( y / canvas.height * ROWS ), 0 ), ROWS - 1 );
		return field[ r ]?.[ c ] ?? 0;
	}

	function getRuleColor( opacity ) {
		const raw   = getComputedStyle( group ).getPropertyValue( '--wp--preset--color--rule' ).trim();
		const match = raw.match( /[\d.]+/g );

		if ( match && match.length >= 3 ) {
			return `rgba(${ match[ 0 ] },${ match[ 1 ] },${ match[ 2 ] },${ opacity })`;
		}

		return `rgba(90,55,12,${ opacity })`;
	}

	const seeds = Array.from( { length: LINE_COUNT }, ( _, i ) => {
		const band    = Math.floor( i / ( LINE_COUNT / 10 ) );
		const opacity = band % 2 === 0
			? 0.07 + Math.random() * 0.05
			: 0.02 + Math.random() * 0.025;
		return {
			x:       Math.random() * canvas.width,
			y:       Math.random() * canvas.height,
			len:     80 + Math.random() * 220,
			opacity,
		};
	} );

	function draw( t ) {
		buildField( t );
		ctx.clearRect( 0, 0, canvas.width, canvas.height );

		for ( const s of seeds ) {
			let x = s.x;
			let y = s.y;
			ctx.beginPath();
			ctx.moveTo( x, y );

			for ( let i = 0; i < s.len; i++ ) {
				const a = getAngle( x, y );
				x += Math.cos( a ) * 2.4;
				y += Math.sin( a ) * 1.8;
				if ( x < -5 || x > canvas.width + 5 || y < -5 || y > canvas.height + 5 ) break;
				ctx.lineTo( x, y );
			}

			ctx.strokeStyle = getRuleColor( s.opacity );
			ctx.lineWidth   = 0.65;
			ctx.stroke();
		}
	}

	let t = 0;

	function tick() {
		t += 0.00035;
		draw( t );
		requestAnimationFrame( tick );
	}

	if ( window.matchMedia( '(prefers-reduced-motion: no-preference)' ).matches ) {
		tick();
	} else {
		buildField( 0 );
		draw( 0 );
	}
} )();
