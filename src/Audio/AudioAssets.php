<?php

/**
 * Audio assets.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Audio;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Manages audio script and style assets.
 */
final class AudioAssets implements Bootable
{
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
		wp_enqueue_script_module(AudioConfig::NAME);
	}

	/**
	 * Registers assets.
	 */
	private function register(): void
	{
		$script = include get_parent_theme_file_path('public/js/interactive/chapter-audio.asset.php');

		wp_register_script_module(
			AudioConfig::NAME,
			get_parent_theme_file_uri('public/js/interactive/chapter-audio.js'),
			$script['dependencies'],
			$script['version']
		);
	}
}
