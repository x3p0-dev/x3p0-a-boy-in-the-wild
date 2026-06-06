<?php

/**
 * Story epoch.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Timeline;

use DateTimeImmutable;
use DateTimeZone;
use WP_Post;

/**
 * The story's origin: the earliest published post. Its publication date is the
 * day-zero from which every elapsed measurement (day, year) is taken, and the
 * post itself is the story's first chapter.
 *
 * Registered as a singleton, so the lookup runs once per request and the post
 * is held on the instance — both the epoch date and the first chapter derive
 * from this single query.
 */
final class Epoch
{
	/**
	 * Whether the origin post has been looked up this request.
	 */
	private bool $resolved = false;

	/**
	 * The earliest published post, or null when none exists.
	 */
	private ?WP_Post $post = null;

	/**
	 * Returns the earliest published post — the story's first chapter — or
	 * null when no published posts exist.
	 */
	public function post(): ?WP_Post
	{
		if (! $this->resolved) {
			$this->post = get_posts([
				'numberposts' => 1,
				'orderby'     => 'date',
				'order'       => 'ASC',
				'post_status' => 'publish'
			])[0] ?? null;

			$this->resolved = true;
		}

		return $this->post;
	}

	/**
	 * Returns the epoch — the origin post's publication date — or null when no
	 * published posts exist.
	 */
	public function resolve(): ?DateTimeImmutable
	{
		if (! $post = $this->post()) {
			return null;
		}

		$date = DateTimeImmutable::createFromFormat(
			'Y-m-d H:i:s',
			$post->post_date,
			new DateTimeZone(wp_timezone_string())
		);

		return $date ?: null;
	}
}
