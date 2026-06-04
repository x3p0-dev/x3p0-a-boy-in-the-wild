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

use WP_Post;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterRepository;

/**
 * Rebrands the built-in post type as "Chapters" and customizes its admin list
 * table presentation.
 */
final class PostDateColumn implements Bootable
{
	public function __construct(private readonly ChapterRepository $chapters) {}

	/**
	 * {@inheritDoc}
	 */
	public function boot(): void
	{
		add_filter('post_date_column_status', $this->filterStatus(...), 10, 2);
		add_filter('post_date_column_time',   $this->filterTime(...), 10, 2);
	}

	/**
	 * Hides the published/scheduled status label above the date column
	 * for chapters so the column only shows the season and date.
	 */
	private function filterStatus(string $status, WP_Post $post): string
	{
		return 'post' === $post->post_type ? '' : $status;
	}

	/**
	 * Replaces the date column's time value with the chapter's season and
	 * publish date so the list table reads in narrative time.
	 */
	private function filterTime(string $time, WP_Post $post): string
	{
		if ('post' !== $post->post_type || ! $timestamp = get_post_timestamp($post)) {
			return $time;
		}

		$season = $this->chapters->forPost($post)->moment()->season()->label();
		$date   = date_i18n(get_option('date_format'), $timestamp);

		return esc_html($season) . '<br>' . esc_html($date);
	}
}
