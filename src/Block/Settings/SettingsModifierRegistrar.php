<?php

/**
 * Settings modifier registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Settings;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Seeds the theme's default settings modifiers into the registry.
 */
final class SettingsModifierRegistrar implements Bootable
{
	/**
	 * Array of settings modifier classnames.
	 */
	private const MODIFIERS = [
		Modifiers\Group::class
	];

	/**
	 * Sets up the initial object state.
	 */
	public function __construct(private readonly SettingsModifierRegistry $registry)
	{}

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		foreach (self::MODIFIERS as $modifier) {
			$blockType = $modifier::blockType();

			if (! $this->registry->isRegistered($blockType)) {
				$this->registry->register($blockType, $modifier);
			}
		}
	}
}
