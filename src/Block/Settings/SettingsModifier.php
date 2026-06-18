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

/**
 * The settings modifier contract defines how block settings modifiers are
 * implemented within the theme. Each modifier declares the block it targets via
 * the `#[ForBlock]` attribute; the dispatcher reads that attribute and routes
 * the `block_type_metadata_settings` filter to the right modifier.
 */
abstract class SettingsModifier
{
	/**
	 * Modifies the block settings.
	 */
	abstract public function modify(array $settings): array;
}
