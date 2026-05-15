<?php

/**
 * Typewriter assets.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Typewriter;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Manages typewriter script assets.
 */
final class TypewriterAssets implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('wp_enqueue_scripts', $this->register(...));
	}

	/**
	 * Enqueues the typewriter script module.
	 */
	public function enqueue(): void
	{
		wp_enqueue_script_module(TypewriterConfig::NAME);
	}

	/**
	 * Registers the typewriter script module.
	 */
	private function register(): void
	{
		$script = include get_theme_file_path('public/js/interactive/typewriter.asset.php');

		wp_register_script_module(
			TypewriterConfig::NAME,
			get_theme_file_uri('public/js/interactive/typewriter.js'),
			$script['dependencies'],
			$script['version']
		);
	}
}
