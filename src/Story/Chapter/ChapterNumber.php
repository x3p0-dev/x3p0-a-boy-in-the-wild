<?php

/**
 * Chapter number value object.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Chapter;

use Stringable;

/**
 * A chapter's position in the published sequence (Chapter 1 onward) and the
 * ways it can be presented. Additional presentations are added here as new
 * methods.
 *
 * The chapter number is a number: cast to a string it is the localized number;
 * the named presentations (label, roman, …) are explicit methods.
 */
final class ChapterNumber implements Stringable
{
	public function __construct(private readonly int $number) {}

	/**
	 * The chapter's number: 1, 2, 3 …
	 */
	public function number(): int
	{
		return $this->number;
	}

	/**
	 * The localized chapter number: "7".
	 */
	public function __toString(): string
	{
		return number_format_i18n($this->number);
	}

	/**
	 * "Chapter 1", "Chapter 14", "Chapter 192".
	 */
	public function label(): string
	{
		return sprintf(
			// Translators: %s is the chapter number.
			_x('Chapter %s', 'chapter number numeric', 'x3p0-a-boy-in-the-wild'),
			number_format_i18n($this->number)
		);
	}

	/**
	 * "I", "XIV", "CXCII". Falls back to the plain number above 3,999, where
	 * standard Roman numerals become impractical.
	 */
	public function roman(): string
	{
		return $this->number > 3999
			? number_format_i18n($this->number)
			: $this->toRoman($this->number);
	}

	/**
	 * "Chapter I", "Chapter XIV", "Chapter CXCII".
	 */
	public function romanLabel(): string
	{
		return sprintf(
			// Translators: %s is the chapter number as a Roman numeral.
			_x('Chapter %s', 'chapter number roman', 'x3p0-a-boy-in-the-wild'),
			$this->roman()
		);
	}

	/**
	 * Converts a positive integer (1–3999) to its Roman numeral string.
	 */
	private function toRoman(int $n): string
	{
		$numerals = [
			1000 => 'M',
			900  => 'CM',
			500  => 'D',
			400  => 'CD',
			100  => 'C',
			90   => 'XC',
			50   => 'L',
			40   => 'XL',
			10   => 'X',
			9    => 'IX',
			5    => 'V',
			4    => 'IV',
			1    => 'I'
		];

		$result = '';

		foreach ($numerals as $value => $numeral) {
			while ($n >= $value) {
				$result .= $numeral;
				$n      -= $value;
			}
		}

		return $result;
	}
}
