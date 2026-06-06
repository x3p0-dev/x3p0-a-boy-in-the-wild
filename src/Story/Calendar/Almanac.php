<?php

/**
 * Story almanac.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Calendar;

/**
 * The story's almanac: the source of its calendars. It defines the bands for
 * each calendar, builds them into resolvers.
 *
 * Seasons reduce a (month, day) pair to `month * 100 + day` — a value that
 * sorts and compares exactly like a clock hour — so a season band is resolved
 * by the identical wrap-aware match as a time-of-day band.
 */
final class Almanac
{
	/**
	 * Calendars built on first request.
	 */
	private ?Calendar $seasons    = null;
	private ?Calendar $timesOfDay = null;
	private ?Calendar $moonPhases = null;

	/**
	 * The story's seasonal calendar (Minnesota seasons).
	 */
	public function seasons(): Calendar
	{
		return $this->seasons ??= new Calendar([
			'early-spring' => self::season(
				label:      __('Early Spring', 'x3p0-a-boy-in-the-wild'),
				startMonth: 3,
				startDay:   21,
				endMonth:   4,
				endDay:     20
			),
			'spring' => self::season(
				label:      __('Spring', 'x3p0-a-boy-in-the-wild'),
				startMonth: 4,
				startDay:   21,
				endMonth:   5,
				endDay:     20
			),
			'late-spring' => self::season(
				label:      __('Late Spring', 'x3p0-a-boy-in-the-wild'),
				startMonth: 5,
				startDay:   21,
				endMonth:   5,
				endDay:     31
			),
			'early-summer' => self::season(
				label:      __('Early Summer', 'x3p0-a-boy-in-the-wild'),
				startMonth: 6,
				startDay:   1,
				endMonth:   7,
				endDay:     10
			),
			'summer' => self::season(
				label:      __('Summer', 'x3p0-a-boy-in-the-wild'),
				startMonth: 7,
				startDay:   11,
				endMonth:   7,
				endDay:     31
			),
			'late-summer' => self::season(
				label:      __('Late Summer', 'x3p0-a-boy-in-the-wild'),
				startMonth: 8,
				startDay:   1,
				endMonth:   9,
				endDay:     7
			),
			'early-autumn' => self::season(
				label:      __('Early Autumn', 'x3p0-a-boy-in-the-wild'),
				startMonth: 9,
				startDay:   8,
				endMonth:   10,
				endDay:     7
			),
			'autumn' => self::season(
				label:      __('Autumn', 'x3p0-a-boy-in-the-wild'),
				startMonth: 10,
				startDay:   8,
				endMonth:   11,
				endDay:     6
			),
			'late-autumn' => self::season(
				label:      __('Late Autumn', 'x3p0-a-boy-in-the-wild'),
				startMonth: 11,
				startDay:   7,
				endMonth:   11,
				endDay:     30
			),
			'deep-winter' => self::season(
				label:      __('Deep Winter', 'x3p0-a-boy-in-the-wild'),
				startMonth: 12,
				startDay:   1,
				endMonth:   1,
				endDay:     14
			),
			'midwinter' => self::season(
				label:      __('Midwinter', 'x3p0-a-boy-in-the-wild'),
				startMonth: 1,
				startDay:   15,
				endMonth:   2,
				endDay:     14
			),
			'late-winter' => self::season(
				label:      __('Late Winter', 'x3p0-a-boy-in-the-wild'),
				startMonth: 2,
				startDay:   15,
				endMonth:   3,
				endDay:     20
			)
		]);
	}

	/**
	 * The story's time-of-day calendar.
	 */
	public function timesOfDay(): Calendar
	{
		return $this->timesOfDay ??= new Calendar([
			'before-dawn' => [
				'start' => 4,
				'end'   => 5,
				'label' => __('Before Dawn', 'x3p0-a-boy-in-the-wild')
			],
			'dawn' => [
				'start' => 5,
				'end'   => 6,
				'label' => __('Dawn', 'x3p0-a-boy-in-the-wild')
			],
			'early-morning' => [
				'start' => 6,
				'end'   => 9,
				'label' => __('Early Morning', 'x3p0-a-boy-in-the-wild')
			],
			'morning' => [
				'start' => 9,
				'end'   => 12,
				'label' => __('Morning', 'x3p0-a-boy-in-the-wild')
			],
			'midday' => [
				'start' => 12,
				'end'   => 14,
				'label' => __('Midday', 'x3p0-a-boy-in-the-wild')
			],
			'afternoon' => [
				'start' => 14,
				'end'   => 17,
				'label' => __('Afternoon', 'x3p0-a-boy-in-the-wild')
			],
			'evening' => [
				'start' => 17,
				'end'   => 19,
				'label' => __('Evening', 'x3p0-a-boy-in-the-wild')
			],
			'dusk' => [
				'start' => 19,
				'end'   => 20,
				'label' => __('Dusk', 'x3p0-a-boy-in-the-wild')
			],
			'late-evening' => [
				'start' => 20,
				'end'   => 22,
				'label' => __('Late Evening', 'x3p0-a-boy-in-the-wild')
			],
			'night' => [
				'start' => 22,
				'end'   => 4,
				'label' => __('Night', 'x3p0-a-boy-in-the-wild')
			]
		]);
	}

	/**
	 * The story's lunar calendar. Its bands are laid over the position in the
	 * synodic cycle as permille (0–999) — the value LunarCycle reduces a
	 * date to — so the new moon's band straddles the 0/999 boundary and is
	 * resolved by the same wrap-aware match the other calendars use.
	 */
	public function moonPhases(): Calendar
	{
		return $this->moonPhases ??= new Calendar([
			'new' => [
				'start' => 938,
				'end'   => 62,
				'label' => __('New Moon', 'x3p0-a-boy-in-the-wild')
			],
			'waxing-crescent' => [
				'start' => 63,
				'end'   => 187,
				'label' => __('Waxing Crescent', 'x3p0-a-boy-in-the-wild')
			],
			'first-quarter' => [
				'start' => 188,
				'end'   => 312,
				'label' => __('First Quarter', 'x3p0-a-boy-in-the-wild')
			],
			'waxing-gibbous' => [
				'start' => 313,
				'end'   => 437,
				'label' => __('Waxing Gibbous', 'x3p0-a-boy-in-the-wild')
			],
			'full' => [
				'start' => 438,
				'end'   => 562,
				'label' => __('Full Moon', 'x3p0-a-boy-in-the-wild')
			],
			'waning-gibbous' => [
				'start' => 563,
				'end'   => 687,
				'label' => __('Waning Gibbous', 'x3p0-a-boy-in-the-wild')
			],
			'last-quarter' => [
				'start' => 688,
				'end'   => 812,
				'label' => __('Last Quarter', 'x3p0-a-boy-in-the-wild')
			],
			'waning-crescent' => [
				'start' => 813,
				'end'   => 937,
				'label' => __('Waning Crescent', 'x3p0-a-boy-in-the-wild')
			]
		]);
	}

	/**
	 * Builds a season band, reducing each (month, day) bound to a single
	 * sortable value.
	 *
	 * @return array{start: int, end: int, label: string}
	 */
	private static function season(
		string $label,
		int $startMonth,
		int $startDay,
		int $endMonth,
		int $endDay
	): array {
		return [
			'start' => $startMonth * 100 + $startDay,
			'end'   => $endMonth * 100 + $endDay,
			'label' => $label
		];
	}
}
