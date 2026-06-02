<?php

/**
 * Chapter field names enum.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Support;

/**
 * The set of chapter field names exposed by both the chapter REST field
 * schema and the `x3p0/chapter` block binding source. Keeping them in one
 * place ensures the two contracts cannot drift apart.
 */
final class ChapterFields
{
	public const DAY          = 'day';
	public const DAY_NUMBER   = 'dayNumber';
	public const YEAR         = 'year';
	public const NUMBER       = 'number';
	public const NUMBER_ROMAN = 'numberRoman';
	public const SEASON       = 'season';
	public const TIME         = 'time';
}
