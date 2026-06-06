<?php

/**
 * Story light state.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Sky;

/**
 * The state of natural light at a moment — whether the sun is up, near the
 * horizon, or down. Where the time of day reads the clock, the light state
 * reads the sun, so the same hour is daylight in summer and dark in winter.
 * The SolarCycle decides which state a moment falls in; each case carries
 * its localized name.
 */
enum LightState: string
{
	case Daylight = 'daylight';
	case Twilight = 'twilight';
	case Dark     = 'dark';

	/**
	 * The localized light-state name: "Daylight", "Twilight", "Dark".
	 */
	public function label(): string
	{
		return match ($this) {
			self::Daylight => __('Daylight', 'x3p0-a-boy-in-the-wild'),
			self::Twilight => __('Twilight', 'x3p0-a-boy-in-the-wild'),
			self::Dark     => __('Dark',     'x3p0-a-boy-in-the-wild')
		};
	}
}
