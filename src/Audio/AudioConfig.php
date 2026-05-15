<?php

/**
 * Audio configuration.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Audio;

/**
 * Immutable configuration for audios.
 */
final class AudioConfig
{
	/**
	 * Unique name/ID used to reference in scripts, cookies, etc.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const NAME = 'x3p0-a-boy-in-the-wild-audio';

	/**
	 * Stores the default audio.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const DEFAULT_FILE = 'public/media/audio/lost.mp3';
}
