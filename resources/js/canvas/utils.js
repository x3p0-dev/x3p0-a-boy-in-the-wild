/**
 * Shared utilities for canvas scene effects.
 *
 * All scene scripts import from this module. Webpack externalizes the
 * `x3p0/canvas-utils` specifier via @wordpress/dependency-extraction-
 * webpack-plugin, so this file is loaded once per page and shared across
 * scenes rather than inlined into each.
 *
 * @file resources/js/canvas/utils.js
 */

/**
 * Set up a canvas with DPR-aware sizing and a resize handler.
 *
 * @param {HTMLCanvasElement} canvas
 * @param {Function}          onResize - called after each resize (optional)
 * @returns {{ ctx: CanvasRenderingContext2D, resize: Function }}
 */
export function setupCanvas( canvas, onResize = null ) {
	const ctx = canvas.getContext( '2d' );

	function resize() {
		const dpr     = window.devicePixelRatio || 1;
		canvas.width  = window.innerWidth  * dpr;
		canvas.height = window.innerHeight * dpr;
		ctx.setTransform( 1, 0, 0, 1, 0, 0 );
		ctx.scale( dpr, dpr );
		if ( onResize ) onResize();
	}

	resize();
	window.addEventListener( 'resize', resize );
	return { ctx, resize };
}

/**
 * Read a CSS colour token from the canvas element, parse out the RGB and
 * alpha components, and return them as a `{ rgb, alpha }` object. The
 * token may be hex (`#7a4010` → alpha 1) or rgba (`rgba(185,165,85,0.14)`
 * → alpha 0.14). The alpha is *intentional* — designers use it to tune
 * how subtle a token should be — so effects must honour it by multiplying
 * per-stop / per-particle alpha against `colour.alpha` rather than
 * replacing it. Use `withAlpha()` to build rgba strings correctly.
 *
 * Scene canvases inherit CSS custom properties from the Entry Group, so
 * reading from the canvas directly is equivalent to reading from the group.
 *
 * @param {HTMLCanvasElement} canvas
 * @param {string}            token    - CSS custom property name (with --)
 * @param {string}            fallback - fallback as 3 or 4 numbers (rgb or
 *                                       rgba), e.g. `'185,165,85,0.14'`
 * @returns {{ rgb: string, alpha: number }}
 */
export function extractColour( canvas, token, fallback ) {
	const raw    = getComputedStyle( canvas ).getPropertyValue( token ).trim() || fallback;
	const tokens = raw.match( /[\d.]+/g );

	if ( tokens && tokens.length >= 3 ) {
		return {
			rgb:   `${ tokens[ 0 ] },${ tokens[ 1 ] },${ tokens[ 2 ] }`,
			alpha: tokens.length >= 4 ? parseFloat( tokens[ 3 ] ) : 1,
		};
	}

	const fb = fallback.match( /[\d.]+/g ) || [ '0', '0', '0' ];
	return {
		rgb:   `${ fb[ 0 ] },${ fb[ 1 ] },${ fb[ 2 ] }`,
		alpha: fb.length >= 4 ? parseFloat( fb[ 3 ] ) : 1,
	};
}

/**
 * Build a CSS `rgba()` string from an extractColour() result, multiplying
 * the token's alpha by an optional per-stop alpha.
 *
 * Example: a token with alpha 0.72, rendered at per-particle alpha 0.30,
 * yields a final rgba alpha of 0.216 — preserving the designer's intent.
 *
 * @param {{ rgb: string, alpha: number }} colour
 * @param {number}                         alpha  - per-stop multiplier (default 1)
 * @returns {string} CSS rgba string
 */
export function withAlpha( colour, alpha = 1 ) {
	return `rgba(${ colour.rgb },${ ( colour.alpha * alpha ).toFixed( 4 ) })`;
}

/**
 * Register a MutationObserver that cancels the animation frame and removes
 * the resize listener when the canvas is removed from the DOM.
 *
 * @param {HTMLCanvasElement}          canvas
 * @param {{ current: number | null }} rafRef  - object with a .current RAF id
 * @param {Function}                   resize  - the resize function to remove
 */
export function createCleanup( canvas, rafRef, resize ) {
	const observer = new MutationObserver( () => {
		if ( ! document.contains( canvas ) ) {
			cancelAnimationFrame( rafRef.current );
			window.removeEventListener( 'resize', resize );
			observer.disconnect();
		}
	} );

	observer.observe( document.body, { childList: true, subtree: true } );
}