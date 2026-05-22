<?php

/**
 * Audio resolver.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Audio;

/**
 * Resolves the current audio from multiple sources.
 */
final class AudioResolver
{
	/**
	 * Gets the current audio.
	 */
	public function getCurrentAudioFile(): string
	{
		$audioId = 0;
		$audioUrl = '';

		if (is_singular('post')) {
			$audioId = get_post_meta(get_queried_object_id(), AudioMeta::META_KEY, true);
		} elseif (is_404()) {
			$audioUrl = get_theme_file_uri('public/media/audio/music/moonless-pine-drift.mp3');
		}

		if ($audioId) {
			$audioUrl = wp_get_attachment_url($audioId);
		}

		return $audioUrl;
	}

	/**
	 * Determines whether there is currently an audio file to play.
	 */
	public function hasAudio(): bool
	{
		return $this->getCurrentAudioFile() !== '';
	}
}
