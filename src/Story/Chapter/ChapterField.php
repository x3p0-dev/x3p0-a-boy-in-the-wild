<?php

/**
 * Chapter field names.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Chapter;

/**
 * The closed set of chapter field names exposed by both the chapter REST field
 * schema and the `x3p0/chapter` block binding source. As an enum, the set is
 * the single source for the field list (via cases()) and lets the presenter
 * render it with an exhaustive match — adding a case forces a rendering arm,
 * so the schema and the presenter cannot drift apart.
 */
enum ChapterField: string
{
	case Day              = 'day';
	case DayLabel         = 'dayLabel';
	case Designation      = 'designation';
	case DesignationRoman = 'designationRoman';
	case Number           = 'number';
	case NumberRoman      = 'numberRoman';
	case Season           = 'season';
	case TimeOfDay        = 'timeOfDay';
	case Type             = 'type';
	case Year             = 'year';
	case YearLabel        = 'yearLabel';

	/**
	 * Every field name, in render order.
	 *
	 * @return array<int, string>
	 */
	public static function names(): array
	{
		return array_map(static fn (self $field): string => $field->value, self::cases());
	}
}
