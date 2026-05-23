<?php

/**
 * Story time support class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Support;

/**
 * Resolves a publication time to a named period of the day (Dawn,
 * Morning, Dusk, Night, etc.).
 */
class ChapterTime
{
	/**
	 * Time-of-day periods. Each entry defines the inclusive start and end
	 * hour (24-hour) for a period, and a translatable name.
	 *
	 * Hours are in 24-hour format. Ranges are inclusive on both ends.
	 * Periods that wrap midnight (e.g. Night: 22–4) are handled by the
	 * wrapsDay flag, mirroring how ChapterSeason handles year-boundary
	 * seasons.
	 *
	 * @return array<int, array{
	 *     start: int,
	 *     end:   int,
	 *     name:  string
	 * }>
	 */
	public static function periods(): array
	{
		return [
			// Before Dawn: 4am – 5am
			[
				'start' => 4,
				'end'   => 5,
				'name'  => __('Before Dawn', 'x3p0-a-boy-in-the-wild')
			],
			// Dawn: 5am – 6am
			[
				'start' => 5,
				'end'   => 6,
				'name'  => __('Dawn', 'x3p0-a-boy-in-the-wild')
			],
			// Early Morning: 6am – 9am
			[
				'start' => 6,
				'end'   => 9,
				'name'  => __('Early Morning', 'x3p0-a-boy-in-the-wild')
			],
			// Morning: 9am – 12pm
			[
				'start' => 9,
				'end'   => 12,
				'name'  => __('Morning', 'x3p0-a-boy-in-the-wild')
			],
			// Midday: 12pm – 2pm
			[
				'start' => 12,
				'end'   => 14,
				'name'  => __('Midday', 'x3p0-a-boy-in-the-wild')
			],
			// Afternoon: 2pm – 5pm
			[
				'start' => 14,
				'end'   => 17,
				'name'  => __('Afternoon', 'x3p0-a-boy-in-the-wild')
			],
			// Evening: 5pm – 7pm
			[
				'start' => 17,
				'end'   => 19,
				'name'  => __('Evening', 'x3p0-a-boy-in-the-wild')
			],
			// Dusk: 7pm – 8pm
			[
				'start' => 19,
				'end'   => 20,
				'name'  => __('Dusk', 'x3p0-a-boy-in-the-wild')
			],
			// Late Evening: 8pm – 10pm
			[
				'start' => 20,
				'end'   => 22,
				'name'  => __('Late Evening', 'x3p0-a-boy-in-the-wild')
			],
			// Night: 10pm – 4am
			[
				'start' => 22,
				'end'   => 4,
				'name'  => __('Night', 'x3p0-a-boy-in-the-wild')
			]
		];
	}

	/**
	 * Resolves a time-of-day period name from a Unix timestamp.
	 */
	public static function fromTimestamp(int $timestamp): string
	{
		$hour = (int) date('G', $timestamp);

		foreach (static::periods() as $period) {
			$wrapsDay = $period['start'] > $period['end'];

			$afterStart = $hour >= $period['start'];
			$beforeEnd  = $hour <= $period['end'];

			if ($wrapsDay ? ($afterStart || $beforeEnd) : ($afterStart && $beforeEnd)) {
				return $period['name'];
			}
		}

		return __('Unknown', 'x3p0-a-boy-in-the-wild');
	}
}
