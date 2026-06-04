<?php

/**
 * Post content service.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Content;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Rebrands the built-in post type as "Chapters" and customizes its admin list
 * table presentation.
 */
final class ManagePostColumns implements Bootable
{
	/**
	 * {@inheritDoc}
	 */
	public function boot(): void
	{
		add_filter('manage_post_columns', $this->filter(...));
	}

	/**
	 * Relabels the post list table columns to match the chapter vocabulary.
	 */
	private function filter(array $columns): array
	{
		return [
			...$columns,
			...array_intersect_key([
				'author' => __('Narrator', 'x3p0-a-boy-in-the-wild'),
				'title'  => __('Chapter',  'x3p0-a-boy-in-the-wild'),
				'date'   => __('Time',     'x3p0-a-boy-in-the-wild')
			], $columns)
		];
	}
}
