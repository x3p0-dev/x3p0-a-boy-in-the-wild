<?php

/**
 * Chapter entity.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Chapter;

use WP_Post;
use X3P0\ABoyInTheWild\Story\Moment\Moment;

/**
 * A published post located on the story's timeline. Its designation (section
 * type + optional number) is authored — read from post meta — while its moment
 * on the story calendar (day, year, season, time of day) is derived from the
 * publication date.
 *
 * Alongside the rich accessors (designation(), moment()), it renders its fields
 * as the named strings the REST schema and `x3p0/chapter` block binding expose.
 * The render() match is exhaustive over ChapterField, so a new field cannot be
 * added without a corresponding presentation.
 */
final class Chapter
{
	public function __construct(
		private readonly WP_Post $post,
		private readonly Moment $moment,
		private readonly ChapterDesignation $designation
	) {}

	/**
	 * The underlying post.
	 */
	public function post(): WP_Post
	{
		return $this->post;
	}

	/**
	 * The chapter's moment on the story calendar.
	 */
	public function moment(): Moment
	{
		return $this->moment;
	}

	/**
	 * The chapter's designation: section type plus optional number.
	 */
	public function designation(): ChapterDesignation
	{
		return $this->designation;
	}

	/**
	 * Renders a single field by its wire name, or null for an unknown field.
	 */
	public function field(string $name): ?string
	{
		$field = ChapterField::tryFrom($name);

		return $field ? $this->render($field) : null;
	}

	/**
	 * Renders every field into a name-keyed payload.
	 *
	 * @return array<string, string>
	 */
	public function fields(): array
	{
		$fields = [];

		foreach (ChapterField::cases() as $field) {
			$fields[$field->value] = $this->render($field);
		}

		return $fields;
	}

	/**
	 * Maps a field to the value-object presentation that backs it.
	 */
	private function render(ChapterField $field): string
	{
		return match ($field) {
			ChapterField::Day              => (string) $this->moment->day(),
			ChapterField::DayLabel         => $this->moment->day()->label(),
			ChapterField::Designation      => $this->designation->label(),
			ChapterField::DesignationRoman => $this->designation->romanLabel(),
			ChapterField::MoonPhase        => $this->moment->moonPhase()->label(),
			ChapterField::Number           => $this->designation->number(),
			ChapterField::NumberRoman      => $this->designation->numberRoman(),
			ChapterField::Season           => $this->moment->season()->label(),
			ChapterField::TimeOfDay        => $this->moment->timeOfDay()->label(),
			ChapterField::Type             => $this->designation->type()->label(),
			ChapterField::Year             => (string) $this->moment->year(),
			ChapterField::YearLabel        => $this->moment->year()->label()
		};
	}
}
