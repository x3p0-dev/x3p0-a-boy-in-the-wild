<?php

/**
 * Chapter designation value object.
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
 * A chapter's designation: its section type and optional number, together with
 * the ways either can be presented. Numbered, it reads "Chapter 7" / "Chapter
 * VII"; unnumbered, it is the bare section label "Prologue". Cast to a string
 * it is the full label.
 */
final class ChapterDesignation implements Stringable
{
	public function __construct(
		private readonly ChapterType $type,
		private readonly ?int $number = null
	) {}

	/**
	 * The section type.
	 */
	public function type(): ChapterType
	{
		return $this->type;
	}

	/**
	 * The localized number — "7" — or "" when unnumbered.
	 */
	public function number(): string
	{
		return $this->number !== null ? number_format_i18n($this->number) : '';
	}

	/**
	 * The number as a Roman numeral — "VII" — or "" when unnumbered. Falls
	 * back to the localized number above 3,999, where Roman numerals become
	 * impractical.
	 */
	public function numberRoman(): string
	{
		if ($this->number === null) {
			return '';
		}

		return $this->number > 3999
			? number_format_i18n($this->number)
			: $this->toRoman($this->number);
	}

	/**
	 * The full designation — "Chapter 7", "Prologue".
	 */
	public function label(): string
	{
		$number = $this->number();

		return $number !== ''
			? sprintf('%s %s', $this->type->label(), $number)
			: $this->type->label();
	}

	/**
	 * The full designation in Roman numerals — "Chapter VII", "Prologue".
	 */
	public function romanLabel(): string
	{
		$number = $this->numberRoman();

		return $number !== ''
			? sprintf('%s %s', $this->type->label(), $number)
			: $this->type->label();
	}

	/**
	 * @inheritDoc
	 */
	public function __toString(): string
	{
		return $this->label();
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
