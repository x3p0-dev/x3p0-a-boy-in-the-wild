<?php

/**
 * Image enum.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Media;

/**
 * Enum of image files bundled with the theme. Each case value is the file path
 * relative to the images folder.
 */
enum Image: string
{
	case ABoyInTheWild          = 'a-boy-in-the-wild.webp';
	case Chapter001Clearing     = 'chapter/001-clearing.webp';
	case Chapter002Map          = 'chapter/002-map.webp';
	case Chapter003Storm        = 'chapter/003-storm.webp';
	case Chapter005Campfire     = 'chapter/005-campfire.webp';
	case SystemSeasonLateSummer = 'system/season-late-summer.webp';
	case Template404Sketch      = 'template/404-sketch.webp';
	case TemplateArcSketch      = 'template/arc-sketch.webp';
	case TemplateArchiveSketch  = 'template/archive-sketch.webp';
	case TemplateAuthorSketch   = 'template/author-sketch.webp';
	case TemplateEraSketch      = 'template/era-sketch.webp';
	case TemplateHomeSketch     = 'template/home-sketch.webp';

	/**
	 * Path to the images folder relative to the theme root.
	 */
	private const BASE_PATH = 'public/media/images';

	/**
	 * Returns the public URL to the image file.
	 */
	public function url(): string
	{
		return get_theme_file_uri(self::BASE_PATH . '/' . $this->value);
	}

	/**
	 * Returns the absolute file path to the image file.
	 */
	public function path(): string
	{
		return get_theme_file_path(self::BASE_PATH . '/' . $this->value);
	}
}
