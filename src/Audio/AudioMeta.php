<?php

/**
 * Audio meta registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Audio;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Registers user meta for storing audio preferences.
 */
final class AudioMeta implements Bootable
{
	/**
	 * Audio ID meta key.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const AUDIO_KEY = 'x3p0_audio';

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('init', $this->register(...));
	}

	/**
	 * Registers post meta for storing the audio.
	 */
	private function register(): void
	{
		register_post_meta('post', self::AUDIO_KEY, [
			'label'             => __('Chapter Audio', 'x3p0-a-boy-in-the-wild'),
			'description'       => __('The associated chapter audio attachment ID.', 'x3p0-a-boy-in-the-wild'),
			'auth_callback'     => fn() => current_user_can('edit_posts'),
			'default'           => 0,
			'revisions_enabled' => true,
			'sanitize_callback' => $this->sanitize(...),
			'show_in_rest'      => true,
			'single'            => true,
			'type'              => 'integer'
		]);
	}

	/**
	 * Sanitizes an audio using whitelist validation.
	 */
	private function sanitize(mixed $value): int
	{
		return absint($value);
	}
}
