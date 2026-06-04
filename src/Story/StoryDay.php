<?php

/**
 * Story day value object.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story;

use Stringable;

/**
 * A chapter day (Day 1 onward) and the ways it can be presented. Additional
 * presentations (e.g. an ordinal "1st Day") are added here as new methods.
 *
 * A day is a number: cast to a string it is the localized day number; the
 * named presentations (label, …) are explicit methods.
 */
final class StoryDay implements Stringable
{
	public function __construct(private readonly int $number) {}

	/**
	 * The day's number: 1, 2, 3 …
	 */
	public function number(): int
	{
		return $this->number;
	}

	/**
	 * The localized day number: "188".
	 */
	public function __toString(): string
	{
		return number_format_i18n($this->number);
	}

	/**
	 * "Day 1", "Day 31", "Day 4748".
	 */
	public function label(): string
	{
		return sprintf(
			// Translators: %s is the chapter day number.
			_x('Day %s', 'chapter day numeric', 'x3p0-a-boy-in-the-wild'),
			number_format_i18n($this->number)
		);
	}
}
