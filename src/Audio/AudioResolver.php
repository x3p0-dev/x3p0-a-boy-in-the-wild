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
	 * Default audio files for specific contexts where no post meta is set.
	 */
	private const DEFAULTS = [
		'404' => 'public/media/audio/music/moonless-pine-drift.mp3',
	];

	/**
	 * Gets the current audio.
	 */
	public function getCurrentAudioFile(): string
	{
		return match (true) {
			is_singular('post') => $this->getPostAudioUrl(get_queried_object_id()),
			is_404()            => get_theme_file_uri(self::DEFAULTS['404']),
			default             => '',
		};
	}

	/**
	 * Gets a specific post's audio URL.
	 */
	private function getPostAudioUrl(int $postId): string
	{
		$audioId = get_post_meta($postId, AudioMeta::AUDIO_KEY, true);

		return $audioId
			? (string) wp_get_attachment_url(absint($audioId))
			: '';
	}

	/**
	 * Determines whether there is currently an audio file to play.
	 */
	public function hasAudio(): bool
	{
		return $this->getCurrentAudioFile() !== '';
	}
}
