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
 *
 * It also owns each field's editor label (via label()), and options() hands the
 * full name-to-label map to the editor's binding-source field picker. Both the
 * render arm and the label arm are exhaustive matches, so a new field carries
 * its presentation and its editor label or the code does not compile.
 */
enum ChapterField: string
{
	case Day              = 'day';
	case DayLabel         = 'dayLabel';
	case Daylight         = 'daylight';
	case DaylightLabel    = 'daylightLabel';
	case Designation      = 'designation';
	case Light            = 'light';
	case MoonPhase        = 'moonPhase';
	case Number           = 'number';
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

	/**
	 * Every field as a name-to-label map, in render order — the field list the
	 * editor's binding-source picker is built from.
	 *
	 * @return array<string, string>
	 */
	public static function options(): array
	{
		$options = [];

		foreach (self::cases() as $field) {
			$options[$field->value] = $field->label();
		}

		return $options;
	}

	/**
	 * The field's editor label: "Day", "Day (Labeled)", "Moon Phase" …
	 */
	public function label(): string
	{
		return match ($this) {
			self::Day              => __('Day',                 'x3p0-a-boy-in-the-wild'),
			self::DayLabel         => __('Day (Labeled)',       'x3p0-a-boy-in-the-wild'),
			self::Daylight         => __('Daylight',            'x3p0-a-boy-in-the-wild'),
			self::DaylightLabel    => __('Daylight (Labeled)',  'x3p0-a-boy-in-the-wild'),
			self::Designation      => __('Designation',         'x3p0-a-boy-in-the-wild'),
			self::Light            => __('Light',               'x3p0-a-boy-in-the-wild'),
			self::MoonPhase        => __('Moon Phase',          'x3p0-a-boy-in-the-wild'),
			self::Number           => __('Number',              'x3p0-a-boy-in-the-wild'),
			self::Season           => __('Season',              'x3p0-a-boy-in-the-wild'),
			self::TimeOfDay        => __('Time of Day',         'x3p0-a-boy-in-the-wild'),
			self::Type             => __('Type',                'x3p0-a-boy-in-the-wild'),
			self::Year             => __('Year',                'x3p0-a-boy-in-the-wild'),
			self::YearLabel        => __('Year (Labeled)',      'x3p0-a-boy-in-the-wild')
		};
	}
}
