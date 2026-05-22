<?php

/**
 * REST API registration.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Rest;

use WP_Post;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Support\ChapterDay;
use X3P0\ABoyInTheWild\Support\ChapterNumber;
use X3P0\ABoyInTheWild\Support\ChapterSeason;
use X3P0\ABoyInTheWild\Support\ChapterTime;
use X3P0\ABoyInTheWild\Support\ChapterYear;

/**
 * Registers fields with the REST API needed for the block in the editor.
 */
final class RestRegistrar implements Bootable
{
	/**
	 * Defines the rewrite REST field attribute name.
	 *
	 * @var  string
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const CHAPTER_FIELD = 'x3p0-a-boy-in-the-wild/chapter';

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('rest_api_init', $this->register(...));
	}

	/**
	 * Registers custom REST fields for use in the editor.
	 */
	private function register(): void
	{
		register_rest_field('post', self::CHAPTER_FIELD, [
			'get_callback' => $this->getChapterData(...),
			'schema' => [
				'type'       => 'object',
				'properties' => [
					'day'         => ['type' => 'string'],
					'year'        => ['type' => 'string'],
					'number'      => ['type' => 'string'],
					'numberRoman' => ['type' => 'string'],
					'season'      => ['type' => 'string'],
					'time'        => ['type' => 'string']
				]
			]
		]);
	}

	private function getChapterData(array $post): array
	{
		$timestamp   = strtotime($post['date']);

		return [
			'day'         => ChapterDay::fromTimestamp($timestamp)->numeric(),
			'year'        => ChapterYear::fromTimestamp($timestamp)->numeric(),
			'number'      => ChapterNumber::fromPostId($post['id'])->numeric(),
			'numberRoman' => ChapterNumber::fromPostId($post['id'])->roman(),
			'season'      => ChapterSeason::fromTimestamp($timestamp),
			'time'        => ChapterTime::fromTimestamp($timestamp)
		];
	}
}
