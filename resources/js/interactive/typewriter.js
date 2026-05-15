import { store, getElement } from '@wordpress/interactivity';

const reducedMotion = window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches;

const STORE = 'x3p0-a-boy-in-the-wild/typewriter';

const { actions } = store( STORE, {
	actions: {
		startTypewriter() {
			const { ref } = getElement();
			const paragraphs = ref.querySelectorAll( 'p' );
			let paragraphDelay = 0;

			paragraphs.forEach( ( p ) => {
				const fullText = p.textContent;
				p.textContent = '';

				setTimeout( () => {
					p.classList.remove( 'is-hidden' );
					p.classList.add( 'is-typing' );
					let charIndex = 0;

					const interval = setInterval( () => {
						p.textContent += fullText[ charIndex ];
						charIndex++;

						if ( charIndex >= fullText.length ) {
							clearInterval( interval );
							p.classList.remove( 'is-typing' );
						}
					}, 30 );
				}, paragraphDelay );

				paragraphDelay += fullText.length * 30 + 200;
			} );
		},
	},
	callbacks: {
		init() {
			const { ref } = getElement();
			const paragraphs = ref.querySelectorAll( 'p' );

			// If the user prefers reduced motion, reveal all paragraphs
			// immediately without the typewriter animation.
			if ( reducedMotion ) {
				paragraphs.forEach( ( p ) => p.classList.add( 'is-visible' ) );
				return;
			}

			// Hide paragraphs via class before the typewriter begins so
			// there's no flash of visible content on load.
			paragraphs.forEach( ( p ) => p.classList.add( 'is-hidden' ) );
			actions.startTypewriter();
		},
	},
} );
