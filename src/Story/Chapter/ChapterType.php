<?php

/**
 * Chapter section type.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Chapter;

/**
 * The story section a post belongs to — the editorial division it represents.
 * Each case carries the localized word that leads its designation ("Chapter",
 * "Prologue", …). Add cases here to support more sections.
 */
enum ChapterType: string
{
	case Prologue  = 'prologue';
	case Chapter   = 'chapter';
	case Interlude = 'interlude';
	case Epilogue  = 'epilogue';
	case Afterword = 'afterword';

	/**
	 * The localized section label: "Prologue", "Chapter", "Interlude" …
	 */
	public function label(): string
	{
		return match ($this) {
			self::Prologue  => __('Prologue',  'x3p0-a-boy-in-the-wild'),
			self::Chapter   => __('Chapter',   'x3p0-a-boy-in-the-wild'),
			self::Interlude => __('Interlude', 'x3p0-a-boy-in-the-wild'),
			self::Epilogue  => __('Epilogue',  'x3p0-a-boy-in-the-wild'),
			self::Afterword => __('Afterword', 'x3p0-a-boy-in-the-wild')
		};
	}
}
