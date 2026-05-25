/**
 * Shared utilities for canvas scene effects.
 *
 * All scene scripts import from this module. Imports are bundled inline by
 * webpack so no separate script-module registration is required.
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
 * Read a CSS custom property from the canvas element, strip its alpha
 * channel, and return the bare RGB components as a comma-separated string
 * for use in rgba() construction.
 *
 * Scene canvases inherit CSS custom properties from the Entry Group, so
 * reading from the canvas directly is equivalent to reading from the group.
 *
 * @param {HTMLCanvasElement} canvas
 * @param {string}            token     - CSS custom property name (with --)
 * @param {string}            fallback  - fallback RGB string, e.g. '90,55,12'
 * @returns {string}
 */
export function extractRGB( canvas, token, fallback ) {
	const raw   = getComputedStyle( canvas ).getPropertyValue( token ).trim()
		|| fallback;
	const match = raw.match( /[\d.]+/g );

	return ( match && match.length >= 3 )
		? `${ match[ 0 ] },${ match[ 1 ] },${ match[ 2 ] }`
		: fallback;
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
