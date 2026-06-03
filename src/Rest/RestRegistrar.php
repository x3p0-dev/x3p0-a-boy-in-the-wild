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

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Support\{
	ChapterDay,
	ChapterFields,
	ChapterNumber,
	ChapterSeason,
	ChapterTime,
	ChapterYear
};

/**
 * Registers fields with the REST API needed in the editor.
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
					ChapterFields::DAY          => ['type' => 'string'],
					ChapterFields::DAY_NUMBER   => ['type' => 'string'],
					ChapterFields::YEAR         => ['type' => 'string'],
					ChapterFields::NUMBER       => ['type' => 'string'],
					ChapterFields::NUMBER_ROMAN => ['type' => 'string'],
					ChapterFields::SEASON       => ['type' => 'string'],
					ChapterFields::TIME         => ['type' => 'string']
				]
			]
		]);
	}

	/**
	 * Resolves the chapter metadata payload returned for each post in
	 * the REST API response.
	 */
	private function getChapterData(array $post): array
	{
		$timestamp = strtotime($post['date']);

		return [
			ChapterFields::DAY          => ChapterDay::fromTimestamp($timestamp)->numeric(),
			ChapterFields::DAY_NUMBER   => strval(ChapterDay::fromTimestamp($timestamp)->number()),
			ChapterFields::YEAR         => ChapterYear::fromTimestamp($timestamp)->numeric(),
			ChapterFields::NUMBER       => ChapterNumber::fromPostId($post['id'])->numeric(),
			ChapterFields::NUMBER_ROMAN => ChapterNumber::fromPostId($post['id'])->roman(),
			ChapterFields::SEASON       => ChapterSeason::fromTimestamp($timestamp),
			ChapterFields::TIME         => ChapterTime::fromTimestamp($timestamp)
		];
	}
}
