<?php

/**
 * Story solar cycle.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Sky;

use DateTimeImmutable;

/**
 * Resolves the solar characteristics of a day at the story's latitude. It is
 * the shared source for daylight-derived readings: the length of the day, and
 * the light at a given moment — whether the sun is up, near the horizon, or
 * down.
 *
 * Both read the same geometry. The sun's hour angle at the horizon, found from
 * the solar declination for the date and the fixed latitude, is the half-day
 * arc from solar noon to sunset. Twice that arc, in hours, is the daylight span;
 * placed on either side of noon it gives the sunrise and sunset a moment's hour
 * is compared against. Northern Minnesota never reaches a polar day or night, so
 * the hour angle is always defined; the cosine is clamped regardless to keep the
 * result finite.
 */
final class SolarCycle
{
	/**
	 * The story's latitude, in degrees north. Northern Minnesota; the precise
	 * location is never revealed, so this is a representative value.
	 */
	private const LATITUDE = 47.5;

	/**
	 * Earth's axial tilt, in degrees — the peak solar declination.
	 */
	private const AXIAL_TILT = 23.45;

	/**
	 * The span on either side of sunrise and sunset counted as twilight rather
	 * than full daylight or dark, in hours.
	 */
	private const TWILIGHT_HOURS = 1.0;

	/**
	 * The hours of daylight on the date.
	 */
	public function daylightHoursAt(DateTimeImmutable $date): float
	{
		return 24.0 * $this->hourAngleAt($date) / M_PI;
	}

	/**
	 * The state of natural light at the moment: daylight between sunrise and
	 * sunset, twilight within the twilight span of either, and dark beyond.
	 */
	public function lightAt(DateTimeImmutable $moment): LightState
	{
		$hour    = (int) $moment->format('G') + (int) $moment->format('i') / 60;
		$halfDay = 12.0 * $this->hourAngleAt($moment) / M_PI;
		$sunrise = 12.0 - $halfDay;
		$sunset  = 12.0 + $halfDay;

		$isDaylight = $hour >= $sunrise && $hour <= $sunset;
		$isTwilight = $hour >= $sunrise - self::TWILIGHT_HOURS
			&& $hour <= $sunset + self::TWILIGHT_HOURS;

		return match (true) {
			$isDaylight => LightState::Daylight,
			$isTwilight => LightState::Twilight,
			default     => LightState::Dark
		};
	}

	/**
	 * The sun's hour angle at the horizon, in radians — the half-day arc from
	 * solar noon to sunset. Day length and the sunrise/sunset offsets from noon
	 * are both read from this single quantity.
	 */
	private function hourAngleAt(DateTimeImmutable $date): float
	{
		$dayOfYear   = (int) $date->format('z') + 1;
		$latitude    = deg2rad(self::LATITUDE);
		$declination = deg2rad(self::AXIAL_TILT)
			* sin(2 * M_PI / 365 * ($dayOfYear - 81));

		$cosine = -tan($latitude) * tan($declination);

		return acos(max(-1.0, min(1.0, $cosine)));
	}
}
