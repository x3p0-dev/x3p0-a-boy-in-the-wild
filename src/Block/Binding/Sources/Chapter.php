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
use X3P0\ABoyInTheWild\Support\ChapterDay;
use X3P0\ABoyInTheWild\Support\ChapterNumber;
use X3P0\ABoyInTheWild\Support\ChapterSeason;
use X3P0\ABoyInTheWild\Support\ChapterTime;
use X3P0\ABoyInTheWild\Support\ChapterYear;

/**
 * Handles registering the `x3p0/chapter` block bindings source and rendering its
 * output based on the given arguments.
 */
final class Chapter extends BindingSource
{
	protected const NAME = 'x3p0/chapter';

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
		$postId = absint($block->context['postId'] ?? get_the_ID());

		return match ($args['field'] ?? '') {
			'day'         => $this->renderDay($postId)?->numeric(),
			'year'        => $this->renderYear($postId)?->numeric(),
			'number'      => $this->renderNumber($postId)?->numeric(),
			'numberRoman' => $this->renderNumber($postId)?->roman(),
			'season'      => $this->renderSeason($postId),
			'time'        => $this->renderTime($postId),
			default       => null
		};
	}

	/**
	 * Returns the story season based on the timestamp.
	 */
	private function renderSeason(int $postId): string
	{
		return ChapterSeason::fromTimestamp(strtotime(get_post($postId)->post_date));
	}

	/**
	 * Returns the story year based on the timestamp.
	 */
	private function renderYear(int $postId): ?ChapterYear
	{
		return ChapterYear::fromTimestamp(strtotime(get_post($postId)->post_date));
	}

	/**
	 * Returns the story day based on the timestamp.
	 */
	private function renderDay(int $postId): ?ChapterDay
	{
		return ChapterDay::fromTimestamp(strtotime(get_post($postId)->post_date));
	}

	/**
	 * Returns the story day based on the timestamp.
	 */
	private function renderNumber(int $postId): ?ChapterNumber
	{
		return ChapterNumber::fromPostId($postId);
	}

	/**
	 * Returns the story time based on the timestamp.
	 */
	private function renderTime(int $postId): string
	{
		return ChapterTime::fromTimestamp(strtotime(get_post($postId)->post_date));
	}
}
