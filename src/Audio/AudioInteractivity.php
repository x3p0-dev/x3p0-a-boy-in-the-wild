<?php

/**
 * Audio interactivity handler.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Audio;

use WP_HTML_Tag_Processor;

/**
 * Manages Interactivity API state for audio playing.
 */
final class AudioInteractivity
{
	/**
	 * Unique name for the store.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const STORE = 'x3p0-a-boy-in-the-wild/audio';

	/**
	 * Directive attributes to add to the HTML.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const DIRECTIVES = [
		'data-wp-interactive'       => self::STORE,
		'data-wp-init'              => 'callbacks.init',
		'data-wp-on--click'         => 'actions.toggle',
		'data-wp-class--is-playing' => 'state.playing',
		'data-wp-class--is-muted'   => 'state.muted',
		'data-wp-bind--aria-label'  => 'state.ariaLabel',
		'data-wp-text'              => 'state.label'
	];

	/**
	 * Default audio volume.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const DEFAULT_VOLUME = 0.1;

	/**
	 * Sets up the initial object state.
	 */
	public function __construct(
		private readonly AudioResolver $resolver,
		private readonly AudioAssets $assets
	) {}

	/**
	 * Helper function for enabling interactivity and enqueuing assets. Note
	 * that assets are necessary for making interactive elements.
	 */
	public function enable(): void
	{
		$this->setState();
		$this->assets->enqueue();
	}

	/**
	 * Add interactive directives.
	 */
	public function addDirectives(WP_HTML_Tag_Processor $processor): WP_HTML_Tag_Processor
	{
		foreach (self::DIRECTIVES as $name => $value) {
			$processor->set_attribute($name, $value);
		}

		return $processor;
	}

	/**
	 * Sets the interactivity state.
	 */
	private function setState(): void
	{
		wp_interactivity_state(self::STORE, [
			'url'    => $this->resolver->getCurrentAudioFile(),
			'volume' => self::DEFAULT_VOLUME,
			'text'   => [
				'listen'      => __('Listen', 'x3p0-a-boy-in-the-wild'),
				'stop'        => __('Stop', 'x3p0-a-boy-in-the-wild'),
				'startSound'  => __('Start chapter sound', 'x3p0-a-boy-in-the-wild'),
				'unmuteSound' => __('Unmute chapter sound', 'x3p0-a-boy-in-the-wild'),
				'muteSound'   => __('Mute chapter sound', 'x3p0-a-boy-in-the-wild')
			]
		]);
	}
}
