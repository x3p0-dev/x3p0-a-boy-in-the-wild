<?php

/**
 * Pattern registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Pattern;

use WP_Block_Patterns_Registry;
use WP_Block_Type_Registry;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Handles registering and unregistering block patterns. It's recommended to
 * register patterns by placing individual files in the `/patterns` folder.
 */
final class PatternRegistrar implements Bootable
{
	/**
	 * Sets up the object state.
	 */
	public function __construct()
	{}

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('after_setup_theme', $this->themeSupport(...));
	}

	/**
	 * Removes theme support for core patterns.
	 */
	private function themeSupport(): void
	{
		remove_theme_support('core-block-patterns');
	}
}
