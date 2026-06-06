<?php

/**
 * Cyclical calendar resolver.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Calendar;

/**
 * A cyclical calendar: an ordered set of named bands over a single comparable
 * value, where a band may wrap past the cycle's end (Night runs 22:00–04:00;
 * Deep Winter runs Dec–Jan).
 *
 * This is the matching mechanism only — it knows nothing about which calendars
 * the story keeps or where their bands come from. The Almanac defines those
 * and hands a ready-built calendar here to resolve against.
 */
final class Calendar
{
	/**
	 * @param array<string, array{start: int, end: int, label: string}> $bands
	 *     Slug-keyed, ordered bands. `start`/`end` are inclusive; a band wraps
	 *     the cycle when `start` is greater than `end`.
	 */
	public function __construct(private readonly array $bands) {}

	/**
	 * Returns the band the point falls in as a `key`/`label` pair, or an
	 * "unknown" band if none contains it. A band whose `start` exceeds its
	 * `end` wraps the cycle boundary and matches points on either side of it.
	 *
	 * @return array{key: string, label: string}
	 */
	public function bandAt(int $point): array
	{
		foreach ($this->bands as $key => $band) {
			$wraps      = $band['start'] > $band['end'];
			$afterStart = $point >= $band['start'];
			$beforeEnd  = $point <= $band['end'];

			if ($wraps ? ($afterStart || $beforeEnd) : ($afterStart && $beforeEnd)) {
				return ['key' => $key, 'label' => $band['label']];
			}
		}

		return [
			'key'   => 'unknown',
			'label' => __('Unknown', 'x3p0-a-boy-in-the-wild')
		];
	}
}
