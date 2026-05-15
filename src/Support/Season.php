<?php

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Support;

class Season
{
	/**
	 * Minnesota seasonal calendar. Each entry defines the inclusive start
	 * and end month/day for a season, and a translation key used to resolve
	 * the localised season name at runtime.
	 *
	 * @return array<string, array{
	 *      start_month: int,
	 *      start_day:   int,
	 *      end_month:   int,
	 *      end_day:     int,
	 *      name:        string
	 *  }>
	 */
	public static function seasons(): array
	{
		return [
			// Early Spring: Mar 21 - Apr 20
			[
				'start_month' => 3,
				'start_day'   => 21,
				'end_month'   => 4,
				'end_day'     => 20,
				'name'        => __('Early Spring', 'x3p0-a-boy-in-the-wild'),
			],
			// Spring: Apr 21 - May 20
			[
				'start_month' => 4,
				'start_day'   => 21,
				'end_month'   => 5,
				'end_day'     => 20,
				'name'        => __('Spring', 'x3p0-a-boy-in-the-wild'),
			],
			// Late Spring: May 21 - May 31
			[
				'start_month' => 5,
				'start_day'   => 21,
				'end_month'   => 5,
				'end_day'     => 31,
				'name'        => __('Late Spring', 'x3p0-a-boy-in-the-wild'),
			],
			// Early Summer: Jun 1 - Jul 10
			[
				'start_month' => 6,
				'start_day'   => 1,
				'end_month'   => 7,
				'end_day'     => 10,
				'name'        => __('Early Summer', 'x3p0-a-boy-in-the-wild'),
			],
			// Summer: Jul 11 - Jul 31
			[
				'start_month' => 7,
				'start_day'   => 11,
				'end_month'   => 7,
				'end_day'     => 31,
				'name'        => __('Summer', 'x3p0-a-boy-in-the-wild'),
			],
			// Late Summer: Aug 1 - Sep 7
			[
				'start_month' => 8,
				'start_day'   => 1,
				'end_month'   => 9,
				'end_day'     => 7,
				'name'        => __('Late Summer', 'x3p0-a-boy-in-the-wild'),
			],
			// Early Autumn: Sep 8 - Oct 7
			[
				'start_month' => 9,
				'start_day'   => 8,
				'end_month'   => 10,
				'end_day'     => 7,
				'name'        => __('Early Autumn', 'x3p0-a-boy-in-the-wild'),
			],
			// Autumn: Oct 8 - Nov 6
			[
				'start_month' => 10,
				'start_day'   => 8,
				'end_month'   => 11,
				'end_day'     => 6,
				'name'        => __('Autumn', 'x3p0-a-boy-in-the-wild'),
			],
			// Late Autumn: Nov 7 - Nov 30
			[
				'start_month' => 11,
				'start_day'   => 7,
				'end_month'   => 11,
				'end_day'     => 30,
				'name'        => __('Late Autumn', 'x3p0-a-boy-in-the-wild'),
			],
			// Deep Winter: Dec 1 - Jan 14
			[
				'start_month' => 12,
				'start_day'   => 1,
				'end_month'   => 1,
				'end_day'     => 14,
				'name'        => __('Deep Winter', 'x3p0-a-boy-in-the-wild'),
			],
			// Midwinter: Jan 15 - Feb 14
			[
				'start_month' => 1,
				'start_day'   => 15,
				'end_month'   => 2,
				'end_day'     => 14,
				'name'        => __('Midwinter', 'x3p0-a-boy-in-the-wild'),
			],
			// Late Winter: Feb 15 - Mar 20
			[
				'start_month' => 2,
				'start_day'   => 15,
				'end_month'   => 3,
				'end_day'     => 20,
				'name'        => __('Late Winter', 'x3p0-a-boy-in-the-wild'),
			],
		];
	}

	/**
	 * Resolves a season name from a month and day.
	 */
	public static function seasonFromDate(int $timestamp): string
	{
		$month = (int) date('n', $timestamp);
		$day   = (int) date('j', $timestamp);

		foreach (static::seasons() as $season) {
			$afterStart = $month > $season['start_month']
				|| ($month === $season['start_month'] && $day >= $season['start_day']);

			$beforeEnd = $month < $season['end_month']
				|| ($month === $season['end_month'] && $day <= $season['end_day']);

			// Season wraps around the year boundary (e.g. Dec 1 – Jan 14)
			$wrapsYear = $season['start_month'] > $season['end_month'];

			if ($wrapsYear ? ($afterStart || $beforeEnd) : ($afterStart && $beforeEnd)) {
				return $season['name'];
			}
		}

		return __('Unknown', 'x3p0-a-boy-in-the-wild');
	}
}
