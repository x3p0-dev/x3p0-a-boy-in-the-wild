<?php

/**
 * Story daylight value object.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Sky;

use Stringable;

/**
 * The daylight on a chapter day, measured in whole hours, and the ways it can
 * be presented. Additional presentations are added here as new methods.
 *
 * A daylight span is a number: cast to a string it is the localized hour count;
 * the named presentations (label, …) are explicit methods.
 */
final class Daylight implements Stringable
{
	public function __construct(private readonly int $hours) {}

	/**
	 * The hours of daylight: 8, 9, 15 …
	 */
	public function hours(): int
	{
		return $this->hours;
	}

	/**
	 * The localized hour count: "9".
	 */
	public function __toString(): string
	{
		return number_format_i18n($this->hours);
	}

	/**
	 * "9 hours of light", "1 hour of light".
	 */
	public function label(): string
	{
		return sprintf(
			// Translators: %s is the number of daylight hours.
			_n(
				'%s Hour of Light',
				'%s Hours of Light',
				$this->hours,
				'x3p0-a-boy-in-the-wild'
			),
			number_format_i18n($this->hours)
		);
	}
}
