<?php

/**
 * Story lunar cycle.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Sky;

use DateTimeImmutable;
use DateTimeZone;

/**
 * Locates an instant within the lunar cycle, measured from a known reference
 * new moon. It returns the position as permille (0–999) of one synodic month
 * so the Almanac's moon-phase calendar can resolve it with the same integer,
 * wrap-aware match it uses for seasons and times of day.
 *
 * This is the moon's counterpart to the trivial (month, day) and hour
 * reductions the Moment performs inline for the cyclical calendars — the
 * arithmetic here is involved enough, and carries enough astronomical
 * constants, to live on its own.
 */
final class LunarCycle
{
	/**
	 * The mean length of one synodic month, in days.
	 */
	private const SYNODIC_DAYS = 29.530588853;

	/**
	 * A reference new moon the cycle is measured from (2000-01-06 18:14 UTC).
	 */
	private const REFERENCE = '2000-01-06 18:14:00';

	/**
	 * The instant's position in the cycle as permille (0–999): 0 at the new
	 * moon, ~500 at the full moon.
	 */
	public function permilleAt(DateTimeImmutable $date): int
	{
		$reference = new DateTimeImmutable(self::REFERENCE, new DateTimeZone('UTC'));
		$days      = ($date->getTimestamp() - $reference->getTimestamp()) / 86400;
		$fraction  = fmod($days, self::SYNODIC_DAYS) / self::SYNODIC_DAYS;

		// fmod keeps the sign of the dividend, so dates before the reference
		// land in [-1, 0); fold those back into a single forward cycle.
		return (int) floor(($fraction < 0 ? $fraction + 1.0 : $fraction) * 1000) % 1000;
	}
}
