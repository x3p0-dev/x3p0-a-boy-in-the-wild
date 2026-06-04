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

use Closure;
use WP_Post;
use X3P0\ABoyInTheWild\Story\Moment\Moment;

/**
 * A published post located on the story's timeline. It sits on two independent
 * axes: its position in the published sequence (the number), and its moment on
 * the story calendar (day, year, season, time).
 *
 * Alongside the rich accessors (number(), moment()), it renders its fields as
 * the named strings the REST schema and `x3p0/chapter` block binding expose.
 * The render() match is exhaustive over ChapterField, so a new field cannot be
 * added without a corresponding presentation.
 *
 * The position is a database count, so it is supplied as a deferred callback:
 * the query runs only the first time the number is asked for, and the result
 * is cached here for the life of the chapter.
 */
final class Chapter
{
	/**
	 * Cached chapter number, resolved on first access.
	 */
	private ?ChapterNumber $number = null;

	/**
	 * @param Closure(): int $position Defers the sequence-position count.
	 */
	public function __construct(
		private readonly WP_Post $post,
		private readonly Moment $moment,
		private readonly Closure $position
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
	 * The chapter's position in the published sequence. The count runs once,
	 * on first access.
	 */
	public function number(): ChapterNumber
	{
		return $this->number ??= new ChapterNumber(($this->position)());
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
			ChapterField::Year             => (string) $this->moment->year(),
			ChapterField::YearLabel        => $this->moment->year()->label(),
			ChapterField::Number           => (string) $this->number(),
			ChapterField::NumberLabel      => $this->number()->label(),
			ChapterField::NumberRoman      => $this->number()->roman(),
			ChapterField::NumberRomanLabel => $this->number()->romanLabel(),
			ChapterField::Season           => $this->moment->season()->label(),
			ChapterField::TimeOfDay        => $this->moment->timeOfDay()->label()
		};
	}
}
