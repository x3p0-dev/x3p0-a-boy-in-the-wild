<?php

/**
 * Story time-of-day value object.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story;

/**
 * A named period of the day on the story's time-of-day calendar. The key is
 * the stable machine identifier (e.g. "before-dawn"); the label is the
 * translated, human-readable name (e.g. "Before Dawn").
 */
final class StoryTimeOfDay
{
	public function __construct(
		private readonly string $key,
		private readonly string $label
	) {}

	/**
	 * The stable machine identifier: "before-dawn", "night" …
	 */
	public function key(): string
	{
		return $this->key;
	}

	/**
	 * The translated, human-readable name: "Before Dawn", "Night" …
	 */
	public function label(): string
	{
		return $this->label;
	}
}
