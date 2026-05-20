<?php

/**
 * Site binding class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding\Sources;

use WP_Block;
use WP_Post;
use X3P0\ABoyInTheWild\Block\Binding\BindingSource;
use X3P0\ABoyInTheWild\Support\StoryDay;
use X3P0\ABoyInTheWild\Support\StoryYear;

/**
 * Handles registering the `x3p0/site-data` block bindings source and rendering its
 * output based on the given arguments.
 */
final class Story extends BindingSource
{
	protected const NAME = 'x3p0/story';

	/**
	 * Stores the post ID.
	 */
	private int $postId = 0;

	private ?WP_Post $firstChapter = null;

	/**
	 * @inheritDoc
	 */
	public function getLabel(): string
	{
		return __('Story Data', 'x3p0-ideas');
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
		$this->postId = absint($block->context['postId'] ?? get_the_ID());

		return match ($args['field'] ?? '') {
			'chapterUrl'        => get_permalink($this->postId),
			'firstChapterUrl'   => $this->renderFirstChapterUrl(),
			'firstChapterLabel' => $this->renderFirstChapterLabel(),
			'day'         => $this->storyDay(strtotime(get_post($this->postId)->post_date))?->number(),
			'dayNumeric'  => $this->storyDay(strtotime(get_post($this->postId)->post_date))?->numeric(),
			'dayOrdinal'  => $this->storyDay(strtotime(get_post($this->postId)->post_date))?->ordinal(),
			'year'              => $this->storyYear(strtotime(get_post($this->postId)->post_date))?->number(),
			'yearNumeric'     => $this->storyYear(strtotime(get_post($this->postId)->post_date))?->numeric(),
			'yearOrdinal'     => $this->storyYear(strtotime(get_post($this->postId)->post_date))?->ordinal(),
			'yearWord'        => $this->storyYear(strtotime(get_post($this->postId)->post_date))?->word(),
			'yearWithArticle' => $this->storyYear(strtotime(get_post($this->postId)->post_date))?->withArticle(),
			default                => null
		};
	}

	private function getFirstChapter(): ?WP_Post
	{
		$posts = get_posts( [
			'numberposts' => 1,
			'order'       => 'ASC',
			'orderby'     => 'date',
			'post_status' => 'publish',
		] );

		if (! empty($posts) && isset($posts[0])) {
			$this->firstChapter = $posts[0];
		}

		return $this->firstChapter;
	}

	private function renderFirstChapterUrl(): ?string
	{
		if (! $post = $this->getFirstChapter()) {
			return null;
		}

		return esc_url(get_permalink($post->ID));
	}

	private function renderFirstChapterLabel(): ?string
	{
		if (! $post = $this->getFirstChapter()) {
			return null;
		}

		return sprintf(
			__('Begin at %s &rarr;', 'x3p0-a-boy-in-the-wild'),
			esc_html(get_the_title($post->ID))
		);
	}

	private function storyYear(int $timestamp): ?StoryYear
	{
		return StoryYear::fromTimestamp($timestamp);
	}

	private function storyDay(int $timestamp): ?StoryDay
	{
		return StoryDay::fromTimestamp($timestamp);
	}
}
