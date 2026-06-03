<?php

/**
 * Settings modifier base class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Settings;

use LogicException;

/**
 * The settings modifier contract defines how block settings modifiers are
 * implemented within the theme. Each modifier targets a single block type via
 * the `BLOCK_TYPE` constant and alters that block's metadata settings.
 */
abstract class SettingsModifier
{
	/**
	 * The block type this modifier targets (e.g., 'core/group'). Subclasses
	 * must override this constant.
	 */
	protected const BLOCK_TYPE = '';

	/**
	 * Returns the block type this modifier targets (e.g., 'core/group').
	 *
	 * Implemented as a static accessor so the registrar can read the target
	 * block without instantiating the modifier, preserving the registry's
	 * lazy instantiation.
	 */
	public static function blockType(): string
	{
		if (static::BLOCK_TYPE === '') {
			throw new LogicException(sprintf(
				// Translators: %s is a PHP classname.
				__('%s must define the BLOCK_TYPE constant', 'x3p0-a-boy-in-the-wild'),
				static::class
			));
		}

		return static::BLOCK_TYPE;
	}

	/**
	 * Modifies the block settings.
	 */
	abstract public function modify(array $settings): array;
}
