<?php

/**
 * Audio interactivity handler.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
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
	 * Toggle action for the interactive script module.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const ACTION_TOGGLE = 'actions.toggle';

	/**
	 * Init callback for the interactive script module.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const CALLBACK_INIT = 'callbacks.init';

	/**
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const STATE_IS_PLAYING = 'state.playing';

	/**
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const STATE_IS_MUTED = 'state.muted';

	/**
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const STATE_ARIA_LABEL = 'state.ariaLabel';

	/**
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const STATE_LABEL = 'state.label';

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
		$attr = [
			'data-wp-interactive'       => self::STORE,
			'data-wp-init'              => self::CALLBACK_INIT,
			'data-wp-on--click'         => self::ACTION_TOGGLE,
			'data-wp-class--is-playing' => self::STATE_IS_PLAYING,
			'data-wp-class--is-muted'   => self::STATE_IS_MUTED,
			'data-wp-bind--aria-label'  => self::STATE_ARIA_LABEL,
			'data-wp-text'              => self::STATE_LABEL
		];

		foreach ($attr as $name => $value) {
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
			'url'               => $this->resolver->getCurrentAudioFile(),
			'volume'            => 0.1,
			'text'   => [
				'listen'      => __('Listen', 'x3p0-a-boy-in-the-wild'),
				'stop'        => __('Stop', 'x3p0-a-boy-in-the-wild'),
				'startSound'  => __('Start chapter sound', 'x3p0-a-boy-in-the-wild'),
				'unmuteSound' => __('Unmute chapter sound', 'x3p0-a-boy-in-the-wild'),
				'muteSound'   => __('Mute chapter sound', 'x3p0-a-boy-in-the-wild'),
			]
		]);
	}
}
