<?php

/**
 * Story season value object.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story;

/**
 * A named season on the story's seasonal calendar. The key is the stable
 * machine identifier (e.g. "deep-winter"); the label is the translated,
 * human-readable name (e.g. "Deep Winter").
 */
final class StorySeason
{
	public function __construct(
		private readonly string $key,
		private readonly string $label
	) {}

	/**
	 * The stable machine identifier: "deep-winter", "midwinter" …
	 */
	public function key(): string
	{
		return $this->key;
	}

	/**
	 * The translated, human-readable name: "Deep Winter", "Midwinter" …
	 */
	public function label(): string
	{
		return $this->label;
	}
}
