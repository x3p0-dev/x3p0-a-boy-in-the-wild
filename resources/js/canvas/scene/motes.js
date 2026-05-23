/**
 * Chapter 2 — The Map I Drew
 * Canvas effect: forest motes drifting across the map.
 *
 * A handful of particles drift slowly left to right at varying speeds and
 * depths, occasionally pausing or reversing as an intermittent breeze would
 * move something light and dry. The effect is subliminal — the map feels like
 * an outdoor document rather than a finished thing on a desk.
 *
 * Canvas class: x3p0-canvas-scene x3p0-canvas-scene--motes
 * Positioning:  fixed (viewport-scale ambient effect)
 * Reduced motion: canvas is created and sized but never animated.
 */

( function () {

	// -------------------------------------------------------------------------
	// CONFIG — all tuneable values in one place.
	// -------------------------------------------------------------------------

	const CONFIG = {
		// Number of mote particles.
		moteCount: 10,

		// Horizontal drift speed range (px/frame, positive = rightward).
		// Kept very slow so motes are subliminal rather than distracting.
		driftSpeedMin: 0.08,
		driftSpeedMax: 0.28,

		// Vertical drift range (px/frame). Slight vertical wobble only.
		// Negative = upward, positive = downward. Range is symmetric.
		verticalWobbleAmp: 0.06,

		// Pause probability per frame (chance a mote briefly stops drifting).
		// Very low — pauses should feel occasional and natural.
		pauseChance: 0.0008,

		// Reversal probability per frame (chance a mote briefly drifts back).
		// Even lower than pause — reversals are rare wind-back moments.
		reversalChance: 0.0003,

		// Duration range for pauses (frames).
		pauseDurationMin: 40,
		pauseDurationMax: 120,

		// Duration range for reversals (frames).
		reversalDurationMin: 20,
		reversalDurationMax: 60,

		// Opacity range. Low but perceptible — present without competing with the map.
		alphaMin: 0.12,
		alphaMax: 0.35,

		// Mote radius range (px). Small and irregular.
		radiusMin: 0.8,
		radiusMax: 2.2,

		// Vertical band within which motes spawn and travel.
		// Expressed as fractions of viewport height (0 = top, 1 = bottom).
		// Constrains effect to roughly the map zone at the top of the chapter.
		bandTop:    0.0,
		bandBottom: 0.52,

		// Horizontal spawn margin — motes start just off the left edge.
		spawnOffsetLeft: -20,

		// Recycle x threshold — motes recycle when this far past right edge.
		recycleOffsetRight: 30,
	};

	// -------------------------------------------------------------------------
	// Canvas setup.
	// -------------------------------------------------------------------------

	const canvas = document.querySelector( '.x3p0-canvas-scene--motes' );

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

	// -------------------------------------------------------------------------
	// Data attribute overrides — any CONFIG key can be set via data-* on canvas.
	// -------------------------------------------------------------------------

	( function () {
		const map = {
			moteCount:           Number,
			driftSpeedMin:       Number,
			driftSpeedMax:       Number,
			verticalWobbleAmp:   Number,
			pauseChance:         Number,
			reversalChance:      Number,
			pauseDurationMin:    Number,
			pauseDurationMax:    Number,
			reversalDurationMin: Number,
			reversalDurationMax: Number,
			alphaMin:            Number,
			alphaMax:            Number,
			radiusMin:           Number,
			radiusMax:           Number,
			bandTop:             Number,
			bandBottom:          Number,
			spawnOffsetLeft:     Number,
			recycleOffsetRight:  Number,
		};

		Object.keys( map ).forEach( ( key ) => {
			if ( canvas.dataset[ key ] !== undefined ) {
				CONFIG[ key ] = map[ key ]( canvas.dataset[ key ] );
			}
		} );
	} )();

	// -------------------------------------------------------------------------
	// Reduced motion guard.
	// -------------------------------------------------------------------------

	if ( window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches ) {
		return;
	}

	// -------------------------------------------------------------------------
	// Colour — read directly from the style variation custom property.
	// The value is always a valid CSS colour. Alpha is controlled per-particle
	// via ctx.globalAlpha, so any alpha in the source value is ignored.
	// -------------------------------------------------------------------------

	const style     = getComputedStyle( group );
	const moteColor = style.getPropertyValue( '--wp--preset--color--ink-accent' ).trim()
		|| '#4a2808';

	// -------------------------------------------------------------------------
	// Helpers.
	// -------------------------------------------------------------------------

	function rand( min, max ) {
		return min + Math.random() * ( max - min );
	}

	function randInt( min, max ) {
		return Math.floor( rand( min, max + 1 ) );
	}

	// -------------------------------------------------------------------------
	// Mote system.
	// -------------------------------------------------------------------------

	/**
	 * A single mote particle.
	 *
	 * State machine: 'drifting' | 'paused' | 'reversing'
	 * Transitions are probabilistic per frame (see CONFIG).
	 */
	function createMote( spawnAnywhere ) {
		const bandH = ( CONFIG.bandBottom - CONFIG.bandTop ) * window.innerHeight;
		const bandY = CONFIG.bandTop * window.innerHeight;

		// spawnAnywhere = true on init so motes are spread across the screen,
		// not all queued at the left edge.
		const x = spawnAnywhere
			? rand( 0, window.innerWidth )
			: CONFIG.spawnOffsetLeft;

		return {
			x,
			y:             rand( bandY, bandY + bandH ),
			radius:        rand( CONFIG.radiusMin, CONFIG.radiusMax ),
			alpha:         rand( CONFIG.alphaMin, CONFIG.alphaMax ),
			driftSpeed:    rand( CONFIG.driftSpeedMin, CONFIG.driftSpeedMax ),
			vertOffset:    rand( 0, Math.PI * 2 ),   // phase for vertical wobble
			vertSpeed:     rand( 0.004, 0.012 ),      // how fast the wobble cycles
			state:         'drifting',
			stateTimer:    0,
			stateDuration: 0,
		};
	}

	// Initialise motes spread across the viewport.
	const motes = Array.from( { length: CONFIG.moteCount }, () => createMote( true ) );

	// -------------------------------------------------------------------------
	// Draw.
	// -------------------------------------------------------------------------

	function drawMote( mote ) {
		ctx.save();
		ctx.globalAlpha = mote.alpha;
		ctx.fillStyle   = moteColor;
		ctx.beginPath();
		ctx.arc( mote.x, mote.y, mote.radius, 0, Math.PI * 2 );
		ctx.fill();
		ctx.restore();
	}

	// -------------------------------------------------------------------------
	// Update.
	// -------------------------------------------------------------------------

	function updateMote( mote ) {
		// Vertical wobble — continuous regardless of horizontal state.
		mote.vertOffset += mote.vertSpeed;
		mote.y += Math.sin( mote.vertOffset ) * CONFIG.verticalWobbleAmp;

		// Clamp y to band.
		const bandH = ( CONFIG.bandBottom - CONFIG.bandTop ) * canvas.height;
		const bandY = CONFIG.bandTop * canvas.height;
		mote.y = Math.max( bandY, Math.min( bandY + bandH, mote.y ) );

		// State machine.
		switch ( mote.state ) {

			case 'drifting':
				mote.x += mote.driftSpeed;

				// Probabilistic transition to pause.
				if ( Math.random() < CONFIG.pauseChance ) {
					mote.state         = 'paused';
					mote.stateTimer    = 0;
					mote.stateDuration = randInt(
						CONFIG.pauseDurationMin,
						CONFIG.pauseDurationMax
					);
					break;
				}

				// Probabilistic transition to reversal.
				if ( Math.random() < CONFIG.reversalChance ) {
					mote.state         = 'reversing';
					mote.stateTimer    = 0;
					mote.stateDuration = randInt(
						CONFIG.reversalDurationMin,
						CONFIG.reversalDurationMax
					);
					break;
				}
				break;

			case 'paused':
				mote.stateTimer++;
				if ( mote.stateTimer >= mote.stateDuration ) {
					mote.state = 'drifting';
				}
				break;

			case 'reversing':
				mote.x -= mote.driftSpeed * 0.4; // drift back slower than forward
				mote.stateTimer++;
				if ( mote.stateTimer >= mote.stateDuration ) {
					mote.state = 'drifting';
				}
				break;
		}

		// Recycle when past right edge.
		if ( mote.x > canvas.width + CONFIG.recycleOffsetRight ) {
			const recycled     = createMote( false );
			mote.x             = recycled.x;
			mote.y             = recycled.y;
			mote.radius        = recycled.radius;
			mote.alpha         = recycled.alpha;
			mote.driftSpeed    = recycled.driftSpeed;
			mote.vertOffset    = recycled.vertOffset;
			mote.vertSpeed     = recycled.vertSpeed;
			mote.state         = 'drifting';
			mote.stateTimer    = 0;
			mote.stateDuration = 0;
		}
	}

	// -------------------------------------------------------------------------
	// Animation loop.
	// -------------------------------------------------------------------------

	let rafId;

	function tick() {
		ctx.clearRect( 0, 0, canvas.width, canvas.height );

		motes.forEach( ( mote ) => {
			updateMote( mote );
			drawMote( mote );
		} );

		rafId = requestAnimationFrame( tick );
	}

	rafId = requestAnimationFrame( tick );

	// -------------------------------------------------------------------------
	// Cleanup — cancel loop if Entry Group is removed from DOM.
	// -------------------------------------------------------------------------

	const observer = new MutationObserver( () => {
		if ( ! document.contains( group ) ) {
			cancelAnimationFrame( rafId );
			window.removeEventListener( 'resize', resize );
			observer.disconnect();
		}
	} );

	observer.observe( document.body, { childList: true, subtree: true } );

} )();
