<?php

/**
 * Block category registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Category;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Registers custom block categories used for variations in the theme.
 */
final class BlockCategoryRegistrar implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_filter('block_categories_all', $this->register(...));
	}

	/**
	 * Appends the theme's custom categories to the block category list.
	 */
	private function register(array $categories): array
	{
		$categories[] = [
			'slug'  => 'x3p0-animations',
			'title' => __('Animations', 'x3p0-a-boy-in-the-wild'),
			'icon'  => null
		];

		return $categories;
	}
}
