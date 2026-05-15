<?php

/**
 * Settings modifier registration class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2009-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-breadcrumbs
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Settings;

/**
 * Registers classes with the settings modifier registry.
 *
 * This class provides a centralized registry of default block settings
 * modifiers. It maps WordPress core block types to their corresponding modifier
 * classes and handles the registration process with the modifier registry.
 */
final class SettingsModifierRegistrar
{
	/**
	 * Map of block types to their modifier class names.
	 *
	 * Keys are WordPress block type identifiers (e.g., 'core/archives').
	 * Values are fully qualified class names of modifier implementations.
	 *
	 * @var array<string, class-string>
	 */
	private const MODIFIERS = [
		'core/group' => Modifiers\Group::class
	];

	/**
	 * Registers default modifiers with the registry.
	 */
	public static function register(SettingsModifierRegistry $registry): void
	{
		foreach (self::MODIFIERS as $key => $modifierClass) {
			if (! $registry->isRegistered($key)) {
				$registry->register($key, $modifierClass);
			}
		}
	}
}
