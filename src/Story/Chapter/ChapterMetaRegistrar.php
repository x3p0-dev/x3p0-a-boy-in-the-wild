<?php

/**
 * Chapter meta registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Chapter;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Registers the editable chapter meta — the section type and number — exposing
 * them to the REST API so the editor's Chapter panel can read and write them.
 */
final class ChapterMetaRegistrar implements Bootable
{
	public const TYPE   = 'x3p0_chapter_type';
	public const NUMBER = 'x3p0_chapter_number';

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('init', $this->register(...));
	}

	/**
	 * Registers the chapter meta keys.
	 */
	public function register(): void
	{
		register_post_meta('post', self::TYPE, [
			'type'              => 'string',
			'single'            => true,
			'default'           => ChapterType::Chapter->value,
			'show_in_rest'      => true,
			'sanitize_callback' => $this->sanitizeType(...),
			'auth_callback'     => static fn (): bool => current_user_can('edit_posts')
		]);

		register_post_meta('post', self::NUMBER, [
			'type'              => 'integer',
			'single'            => true,
			'show_in_rest'      => true,
			'sanitize_callback' => 'absint',
			'auth_callback'     => static fn (): bool => current_user_can('edit_posts')
		]);
	}

	/**
	 * Constrains the section type to a known case, falling back to a chapter.
	 */
	private function sanitizeType(string $value): string
	{
		return ChapterType::tryFrom($value)?->value ?? ChapterType::Chapter->value;
	}
}
