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
use X3P0\ABoyInTheWild\Story\StoryAlmanac;
use X3P0\ABoyInTheWild\Story\StoryDay;
use X3P0\ABoyInTheWild\Story\StoryEpoch;
use X3P0\ABoyInTheWild\Story\StoryLunarCycle;
use X3P0\ABoyInTheWild\Story\StoryMoonPhase;
use X3P0\ABoyInTheWild\Story\StorySeason;
use X3P0\ABoyInTheWild\Story\StoryTimeOfDay;
use X3P0\ABoyInTheWild\Story\StoryYear;

/**
 * A point in time read on the story's calendar. The day and year are elapsed
 * measurements from the Epoch; the season and time of day are bands on the
 * Almanac's calendars.
 *
 * All five are functions of the one instant, so the moment resolves each on
 * demand — the day and year both read the single epoch-to-date interval. The
 * Epoch, Almanac, and Lunar Cycle are injected by the MomentFactory that builds
 * it.
 */
final class Moment
{
	public function __construct(
		private readonly DateTimeImmutable $date,
		private readonly StoryEpoch        $epoch,
		private readonly StoryAlmanac      $almanac,
		private readonly StoryLunarCycle   $lunar
	) {}

	/**
	 * The story day this moment falls on.
	 */
	public function day(): StoryDay
	{
		$elapsed = $this->elapsed();
		return new StoryDay($elapsed ? max(1, $elapsed->days + 1) : 1);
	}

	/**
	 * The story year this moment falls in.
	 */
	public function year(): StoryYear
	{
		$elapsed = $this->elapsed();
		return new StoryYear($elapsed ? max(1, $elapsed->y + 1) : 1);
	}

	/**
	 * The season this moment falls in.
	 */
	public function season(): StorySeason
	{
		$monthDay = (int) $this->date->format('n') * 100 + (int) $this->date->format('j');

		return new StorySeason(...$this->almanac->seasons()->bandAt($monthDay));
	}

	/**
	 * The time of day this moment falls in.
	 */
	public function timeOfDay(): StoryTimeOfDay
	{
		$hour = (int) $this->date->format('G');

		return new StoryTimeOfDay(...$this->almanac->timesOfDay()->bandAt($hour));
	}

	/**
	 * The moon phase this moment falls in.
	 */
	public function moonPhase(): StoryMoonPhase
	{
		$permille = $this->lunar->permilleAt($this->date);

		return new StoryMoonPhase(...$this->almanac->moonPhases()->bandAt($permille));
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
