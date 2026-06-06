<?php

/**
 * Story moment.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Moment;

use DateInterval;
use DateTimeImmutable;
use X3P0\ABoyInTheWild\Story\Calendar\Almanac;
use X3P0\ABoyInTheWild\Story\Calendar\MoonPhase;
use X3P0\ABoyInTheWild\Story\Calendar\Season;
use X3P0\ABoyInTheWild\Story\Calendar\TimeOfDay;
use X3P0\ABoyInTheWild\Story\Sky\Daylight;
use X3P0\ABoyInTheWild\Story\Sky\LightState;
use X3P0\ABoyInTheWild\Story\Sky\LunarCycle;
use X3P0\ABoyInTheWild\Story\Sky\SolarCycle;
use X3P0\ABoyInTheWild\Story\Timeline\Day;
use X3P0\ABoyInTheWild\Story\Timeline\Epoch;
use X3P0\ABoyInTheWild\Story\Timeline\Year;

/**
 * A point in time read on the story's calendar. The day and year are elapsed
 * measurements from the Epoch; the season and time of day are bands on the
 * Almanac's calendars.
 *
 * All seven are functions of the one instant, so the moment resolves each on
 * demand — the day and year both read the single epoch-to-date interval. The
 * Epoch, Almanac, Lunar Cycle, and Solar Cycle are injected by the MomentFactory
 * that builds it.
 */
final class Moment
{
	public function __construct(
		private readonly DateTimeImmutable $date,
		private readonly Epoch        $epoch,
		private readonly Almanac      $almanac,
		private readonly LunarCycle   $lunar,
		private readonly SolarCycle   $solar
	) {}

	/**
	 * The story day this moment falls on.
	 */
	public function day(): Day
	{
		$elapsed = $this->elapsed();
		return new Day($elapsed ? max(1, $elapsed->days + 1) : 1);
	}

	/**
	 * The story year this moment falls in.
	 */
	public function year(): Year
	{
		$elapsed = $this->elapsed();
		return new Year($elapsed ? max(1, $elapsed->y + 1) : 1);
	}

	/**
	 * The season this moment falls in.
	 */
	public function season(): Season
	{
		$monthDay = (int) $this->date->format('n') * 100 + (int) $this->date->format('j');

		return new Season(...$this->almanac->seasons()->bandAt($monthDay));
	}

	/**
	 * The time of day this moment falls in.
	 */
	public function timeOfDay(): TimeOfDay
	{
		$hour = (int) $this->date->format('G');

		return new TimeOfDay(...$this->almanac->timesOfDay()->bandAt($hour));
	}

	/**
	 * The moon phase this moment falls in.
	 */
	public function moonPhase(): MoonPhase
	{
		$permille = $this->lunar->permilleAt($this->date);

		return new MoonPhase(...$this->almanac->moonPhases()->bandAt($permille));
	}

	/**
	 * The daylight on the day this moment falls on.
	 */
	public function daylight(): Daylight
	{
		return new Daylight((int) round($this->solar->daylightHoursAt($this->date)));
	}

	/**
	 * The state of natural light at this moment.
	 */
	public function light(): LightState
	{
		return $this->solar->lightAt($this->date);
	}

	/**
	 * The elapsed interval from the epoch to this moment, or null when there
	 * is no epoch yet or this moment precedes it. The single source the day
	 * and year are both read from.
	 */
	private function elapsed(): ?DateInterval
	{
		$epoch = $this->epoch->resolve();

		return ($epoch && $this->date >= $epoch)
			? $epoch->diff($this->date)
			: null;
	}
}
