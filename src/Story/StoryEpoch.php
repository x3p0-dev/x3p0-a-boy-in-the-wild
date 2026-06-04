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

namespace X3P0\ABoyInTheWild\Story;

use DateTimeImmutable;
use DateTimeZone;

/**
 * The story's day-zero: the publication date of the earliest published
 * chapter. Every elapsed measurement (day, year) is taken from here.
 *
 * Registered as a singleton, so the database lookup runs once per request and
 * the resolved value is held on the instance — no static state.
 */
final class StoryEpoch
{
	/**
	 * Whether the epoch has been resolved this request.
	 */
	private bool $resolved = false;

	/**
	 * The resolved epoch, or null when no chapters have been published.
	 */
	private ?DateTimeImmutable $epoch = null;

	/**
	 * Returns the epoch, or null when no published chapters exist.
	 */
	public function resolve(): ?DateTimeImmutable
	{
		if ($this->resolved) {
			return $this->epoch;
		}

		global $wpdb;

		$date = $wpdb->get_var(
			"SELECT post_date FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date ASC LIMIT 1"
		);

		$parsed = $date ? DateTimeImmutable::createFromFormat(
			'Y-m-d H:i:s',
			$date,
			new DateTimeZone(wp_timezone_string())
		) : false;

		$this->epoch    = $parsed ?: null;
		$this->resolved = true;

		return $this->epoch;
	}
}
