<?php

/**
 * Story year support class.
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
 * Resolves a post's publication date to a chapter year (Year 1 onward) and
 * formats it in whichever style the caller needs.
 *
 * The epoch is shared with StoryDay via StoryEpoch, so the database query
 * runs at most once per request regardless of how many instances of either
 * class are created.
 */
class ChapterYear
{
	/**
	 * Builds an instance from a resolved year number. Use one of the
	 * named factories below to construct the value.
	 */
	private function __construct(private readonly int $year) {}

	/**
	 * Resolves the chapter year for a given post based on its
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
	 * Resolves the chapter year from a Unix timestamp.
	 */
	public static function fromTimestamp(int $timestamp): static
	{
		$zone = new DateTimeZone(wp_timezone_string());
		$date = (new DateTimeImmutable('now', $zone))->setTimestamp($timestamp);

		return static::fromDate($date);
	}

	/**
	 * Resolves the chapter year by diffing the given date against the
	 * shared story epoch.
	 */
	public static function fromDate(DateTimeImmutable $date): static
	{
		$epoch = StoryEpoch::get();
		$year  = 1;

		if ($epoch !== false && $date >= $epoch) {
			$year = max(1, $epoch->diff($date)->y + 1);
		}

		return new static($year);
	}

	/**
	 * Returns the raw year number: 1, 2, 3 …
	 */
	public function number(): int
	{
		return $this->year;
	}

	/**
	 * "Year 1", "Year 14", "Year 30".
	 */
	public function numeric(): string
	{
		return sprintf(
			// Translators: %d is the chapter year number.
			_x('Year %d', 'chapter year numeric', 'x3p0-a-boy-in-the-wild'),
			$this->year
		);
	}
}
