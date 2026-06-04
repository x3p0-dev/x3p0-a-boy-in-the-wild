<?php

/**
 * Story year value object.
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
 * A chapter year (Year 1 onward) and the ways it can be presented. Additional
 * presentations (e.g. an ordinal "1st Year") are added here as new methods.
 *
 * A year is a number: cast to a string it is the year number. Years stay small
 * enough that they need no thousands grouping, so the raw value is used.
 */
final class StoryYear implements Stringable
{
	public function __construct(private readonly int $number) {}

	/**
	 * The year's number: 1, 2, 3 …
	 */
	public function number(): int
	{
		return $this->number;
	}

	/**
	 * The year number: "2".
	 */
	public function __toString(): string
	{
		return (string) $this->number;
	}

	/**
	 * "Year 1", "Year 14", "Year 30".
	 */
	public function label(): string
	{
		return sprintf(
			// Translators: %d is the chapter year number.
			_x('Year %d', 'chapter year numeric', 'x3p0-a-boy-in-the-wild'),
			$this->number
		);
	}
}
