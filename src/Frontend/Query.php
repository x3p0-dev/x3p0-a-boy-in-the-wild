<?php

/**
 * Frontend Query class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Frontend;

use WP;
use WP_Query;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Handles modifications to the main WordPress query on the front end.
 */
final class Query implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('pre_get_posts', $this->preGetPosts(...));
		add_action('parse_request', $this->parseRequest(...));
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

	/**
	 * When using a paged Query Loop block, WordPress doesn't set the `paged`
	 * query var. So functions like `is_paged()` do not work correctly for
	 * these types of paginated views, and the `paged` body class is missing.
	 * This action checks for that case and sets the `paged` query var.
	 */
	private function parseRequest(WP $wp): void
	{
		$page = $this->getQueryBlockPage();

		if (1 < $page) {
			$wp->query_vars['paged'] = $page;
		}
	}

	/**
	 * Gets the current page number when there's a paginated Query Loop
	 * block. WordPress doesn't have a conditional function for this.
	 */
	private function getQueryBlockPage(): int
	{
		// Get the URL query for the requested URI.
		$query = wp_parse_url(esc_url_raw(add_query_arg([])), PHP_URL_QUERY);

		// Bail early if this is not a paginated page.
		if (
			! $query
			|| ! str_contains($query, 'query-')
			|| ! str_contains($query, 'page=')
		) {
			return 0;
		}

		// Checks for `?query-page={x}` and `query-{x}-page={y}`.
		preg_match('#query-(\d+-)?page=(\d+)#', $query, $matches);

		return isset($matches[2]) ? absint($matches[2]) : 0;
	}
}
