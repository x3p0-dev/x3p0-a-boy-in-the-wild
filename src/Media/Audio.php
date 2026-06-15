<?php

/**
 * Audio enum.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Media;

/**
 * Enum of audio files bundled with the theme. Each case value is the file path
 * relative to the audio folder.
 */
enum Audio: string
{
	case MoonlessPineDrift = 'music/moonless-pine-drift.mp3';
	case HalfFinishedChord = 'uploads/music/half-finished-chord.mp3';
	case DeepHush          = 'uploads/sounds/deep-hush.mp3';
	case RainInTheHollow   = 'uploads/sounds/rain-in-the-hollow.mp3';
	case TheSepiaAfternoon = 'uploads/sounds/the-sepia-afternoon.mp3';

	/**
	 * Path to the audio folder relative to the theme root.
	 */
	private const BASE_PATH = 'public/media/audio';

	/**
	 * Returns the public URL to the audio file.
	 */
	public function url(): string
	{
		return get_theme_file_uri(self::BASE_PATH . '/' . $this->value);
	}

	/**
	 * Returns the absolute file path to the audio file.
	 */
	public function path(): string
	{
		return get_theme_file_path(self::BASE_PATH . '/' . $this->value);
	}
}
