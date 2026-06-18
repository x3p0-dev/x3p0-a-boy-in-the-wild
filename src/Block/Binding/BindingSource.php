<?php

/**
 * Block Bindings Source interface.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding;

use WP_Block;

/**
 * The Block Bindings Source contract defines how block binding sources should
 * be implemented within the theme.
 */
abstract class BindingSource
{
	/**
	 * The binding source identifier (e.g., 'x3p0/chapter'). Subclasses
	 * must override this constant.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 * @todo Make abstract with PHP 8.4+ requirement.
	 */
	public const NAME = '';

	/**
	 * What contexts (if any) the binding source uses. Optional.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	protected const USES_CONTEXT = [];

	/**
	 * Returns the human-readable label for the binding source.
	 */
	abstract public function getLabel(): string;

	/**
	 * Returns the array of block context keys this binding uses.
	 */
	public function usesContext(): array
	{
		return static::USES_CONTEXT;
	}

	/**
	 * Handles the binding logic and returns the bound value.
	 */
	abstract public function callback(array $args, WP_Block $block, string $name): string|int|null;
}
