<?php

/**
 * Chapter binding class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding\Sources;

use WP_Block;
use X3P0\ABoyInTheWild\Block\Binding\BindingSource;
use X3P0\ABoyInTheWild\Support\{
	ChapterDay,
	ChapterFields,
	ChapterNumber,
	ChapterSeason,
	ChapterTime,
	ChapterYear
};

/**
 * Handles registering the `x3p0/chapter` block bindings source and rendering its
 * output based on the given arguments.
 */
final class Chapter extends BindingSource
{
	public const NAME = 'x3p0/chapter';

	/**
	 * @inheritDoc
	 */
	public function getLabel(): string
	{
		return __('Chapter Data', 'x3p0-a-boy-in-the-wild');
	}

	/**
	 * @inheritDoc
	 */
	public function usesContext(): array
	{
		return ['postId'];
	}

	/**
	 * @inheritDoc
	 */
	public function callback(array $args, WP_Block $block, string $name): ?string
	{
		$postId    = absint($block->context['postId'] ?? get_the_ID());
		$timestamp = get_post_timestamp($postId);

		return match ($args['field'] ?? '') {
			ChapterFields::DAY          => ChapterDay::fromTimestamp($timestamp)->numeric(),
			ChapterFields::DAY_NUMBER   => strval(ChapterDay::fromTimestamp($timestamp)->number()),
			ChapterFields::YEAR         => ChapterYear::fromTimestamp($timestamp)->numeric(),
			ChapterFields::NUMBER       => ChapterNumber::fromPostId($postId)->numeric(),
			ChapterFields::NUMBER_ROMAN => ChapterNumber::fromPostId($postId)->roman(),
			ChapterFields::SEASON       => ChapterSeason::fromTimestamp($timestamp),
			ChapterFields::TIME         => ChapterTime::fromTimestamp($timestamp),
			default                     => null
		};
	}
}
