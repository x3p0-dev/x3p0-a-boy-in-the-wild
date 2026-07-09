<?php

/**
 * Audio assets.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Audio;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Asset\AssetResolver;

/**
 * Manages audio script and style assets.
 */
final class AudioAssets implements Bootable
{
	/**
	 * Audio script module ID.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const AUDIO_MODULE_ID = 'x3p0-a-boy-in-the-wild/audio';

	/**
	 * Audio script module path.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const AUDIO_MODULE_PATH = 'public/js/interactive/audio.js';

	public function __construct(private readonly AssetResolver $assetResolver)
	{}

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('wp_enqueue_scripts', $this->register(...));
	}

	/**
	 * Enqueues assets.
	 */
	public function enqueue(): void
	{
		wp_enqueue_script_module(self::AUDIO_MODULE_ID);
	}

	/**
	 * Registers assets.
	 */
	private function register(): void
	{
		$module = $this->assetResolver->asset(self::AUDIO_MODULE_PATH);

		wp_register_script_module(
			self::AUDIO_MODULE_ID,
			$module->fileUrl(),
			$module->dependencies(),
			$module->version()
		);
	}
}
