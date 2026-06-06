<?php

/**
 * Story moon phase value object.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Calendar;

/**
 * A named phase on the story's lunar cycle. The key is the stable machine
 * identifier (e.g. "waxing-crescent"); the label is the translated,
 * human-readable name (e.g. "Waxing Crescent").
 */
final class MoonPhase
{
	public function __construct(
		private readonly string $key,
		private readonly string $label
	) {}

	/**
	 * The stable machine identifier: "new", "waxing-crescent", "full" …
	 */
	public function key(): string
	{
		return $this->key;
	}

	/**
	 * The translated, human-readable name: "New Moon", "Full Moon" …
	 */
	public function label(): string
	{
		return $this->label;
	}
}
