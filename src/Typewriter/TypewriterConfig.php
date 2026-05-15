<?php

/**
 * Typewriter configuration.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Typewriter;

/**
 * Immutable configuration for the typewriter feature.
 */
final class TypewriterConfig
{
	/**
	 * Script module handle.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const NAME = 'x3p0/typewriter';

	/**
	 * CSS class that triggers the typewriter effect on a block.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const CSS_CLASS = 'x3p0-typewriter';
}
