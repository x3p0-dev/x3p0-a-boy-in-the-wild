<?php

/**
 * Frontend Query class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Frontend;

use WP_Query;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Handles modifications to the main WordPress query on the front end.
 */
final class FrontendQuery implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('pre_get_posts', $this->preGetPosts(...));
	}

	/**
	 * Loads all posts in ascending order on the blog home and archive views
	 * so that the story reads from the first chapter to the last.
	 */
	private function preGetPosts(WP_Query $query): void
	{
		if (! $query->is_main_query() || is_admin()) {
			return;
		}

		if (! $query->is_home() && ! $query->is_archive()) {
			return;
		}

		$query->set('posts_per_page', -1);
		$query->set('order', 'ASC');
	}
}