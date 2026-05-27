<?php

/**
 * Story day support class.
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
use WP_Post;

/**
 * Resolves a post's publication date to a chapter day (Day 1 onward) and
 * formats it in whichever style the caller needs.
 *
 * The epoch is shared with StoryYear via StoryEpoch, so the database query
 * runs at most once per request regardless of how many instances of either
 * class are created.
 */
class ChapterDay
{
	/**
	 * Builds an instance from a resolved day number. Use one of the
	 * named factories below to construct the value.
	 */
	private function __construct(private readonly int $day) {}

	/**
	 * Resolves the chapter day for a given post based on its
	 * publication date.
	 */
	public static function fromPost(WP_Post $post): static
	{
		$zone = new DateTimeZone(wp_timezone_string());
		$date = DateTimeImmutable::createFromFormat(
			'Y-m-d H:i:s',
			$post->post_date,
			$zone
		);

		return static::fromDate($date ?: new DateTimeImmutable('now', $zone));
	}

	/**
	 * Resolves the chapter day from a Unix timestamp.
	 */
	public static function fromTimestamp(int $timestamp): static
	{
		$zone = new DateTimeZone(wp_timezone_string());
		$date = (new DateTimeImmutable('now', $zone))->setTimestamp($timestamp);

		return static::fromDate($date);
	}

	/**
	 * Resolves the chapter day by diffing the given date against the
	 * shared story epoch.
	 */
	public static function fromDate(DateTimeImmutable $date): static
	{
		$epoch = StoryEpoch::get();
		$day   = 1;

		if ($epoch !== false && $date >= $epoch) {
			// diff()->days gives the total number of complete elapsed days.
			// Add 1 so the epoch date itself is Day 1.
			$day = max(1, $epoch->diff($date)->days + 1);
		}

		return new static($day);
	}

	/**
	 * Returns the raw day number: 1, 2, 3 …
	 */
	public function number(): int
	{
		return $this->day;
	}

	/**
	 * "Day 1", "Day 31", "Day 4748".
	 */
	public function numeric(): string
	{
		return sprintf(
			// Translators: %s is the chapter day number.
			_x('Day %s', 'chapter day numeric', 'x3p0-a-boy-in-the-wild'),
			number_format_i18n($this->day)
		);
	}
}
