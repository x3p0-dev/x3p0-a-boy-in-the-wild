<?php

/**
 * Group settings modifier.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Settings\Modifiers;

use X3P0\ABoyInTheWild\Block\ForBlock;
use X3P0\ABoyInTheWild\Block\Settings\SettingsModifier;

#[ForBlock('core/group')]
final class Group extends SettingsModifier
{
	/**
	 * {@inheritDoc}
	 *
	 * Adds `textAlign` support for the Group block. This is needed to align
	 * sub-blocks (e.g., Heading, Paragraph) in one swoop rather than
	 * aligning them individually.
	 */
	public function modify(array $settings): array
	{
		$settings['supports']['typography']              ??= [];
		$settings['supports']['typography']['textAlign'] ??= true;

		return $settings;
	}
}
