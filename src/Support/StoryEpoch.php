<?php

/**
 * Story epoch support class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Support;

use DateTimeImmutable;
use DateTimeZone;

/**
 * Resolves and caches the story epoch — the publication date of the earliest
 * published chapter. Shared by StoryYear and StoryDay so the query runs once
 * per request regardless of how many instances of either class are created.
 */
class StoryEpoch
{
	private static DateTimeImmutable|false|null $epoch = null;

	/**
	 * Returns the epoch as a DateTimeImmutable, or false if no published
	 * chapters exist.
	 */
	public static function get(): DateTimeImmutable|false
	{
		if (self::$epoch !== null) {
			return self::$epoch;
		}

		global $wpdb;

		$date = $wpdb->get_var(
			"SELECT post_date FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' ORDER BY post_date ASC LIMIT 1"
		);

		if (!$date) {
			self::$epoch = false;
			return false;
		}

		$zone        = new DateTimeZone(wp_timezone_string());
		self::$epoch = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $date, $zone);

		return self::$epoch;
	}

	/**
	 * Clears the cache. Useful in tests.
	 */
	public static function flush(): void
	{
		self::$epoch = null;
	}
}
