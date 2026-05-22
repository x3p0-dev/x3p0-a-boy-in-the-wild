<?php

/**
 * Story binding class.
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
 * Handles registering the `x3p0/story` block bindings source and rendering its
 * output based on the given arguments.
 */
final class Story extends BindingSource
{
	protected const NAME = 'x3p0/story';

	/**
	 * Stores the first chapter.
	 */
	private ?WP_Post $firstChapter = null;

	/**
	 * @inheritDoc
	 */
	public function getLabel(): string
	{
		return __('Story Data', 'x3p0-a-boy-in-the-wild');
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
			'chapterUrl'        => get_permalink($postId),
			'firstChapterUrl'   => $this->renderFirstChapterUrl(),
			'firstChapterLabel' => $this->renderFirstChapterLabel(),
			'day'               => $this->storyDay($postId)?->number(),
			'dayNumeric'        => $this->storyDay($postId)?->numeric(),
			'dayOrdinal'        => $this->storyDay($postId)?->ordinal(),
			'year'              => $this->storyYear($postId)?->number(),
			'yearNumeric'       => $this->storyYear($postId)?->numeric(),
			'yearOrdinal'       => $this->storyYear($postId)?->ordinal(),
			'yearWord'          => $this->storyYear($postId)?->word(),
			'yearWithArticle'   => $this->storyYear($postId)?->withArticle(),
			default             => null
		};
	}

	/**
	 * Returns the first published chapter/post.
	 */
	private function getFirstChapter(): ?WP_Post
	{
		if (! is_null($this->firstChapter)) {
			return $this->firstChapter;
		}

		$posts = get_posts([
			'numberposts' => 1,
			'order'       => 'ASC',
			'orderby'     => 'date',
			'post_status' => 'publish',
		]);

		if (! empty($posts) && isset($posts[0])) {
			$this->firstChapter = $posts[0];
		}

		return $this->firstChapter;
	}

	/**
	 * Renders the first chapter's URL.
	 */
	private function renderFirstChapterUrl(): ?string
	{
		if (! $post = $this->getFirstChapter()) {
			return null;
		}

		return esc_url(get_permalink($post->ID));
	}

	/**
	 * Renders the first chapter's label.
	 */
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

	/**
	 * Returns the story year based on the timestamp.
	 */
	private function storyYear(int $postId): ?StoryYear
	{
		return StoryYear::fromTimestamp(strtotime(get_post($postId)->post_date));
	}

	/**
	 * Returns the story day based on the timestamp.
	 */
	private function storyDay(int $postId): ?StoryDay
	{
		return StoryDay::fromTimestamp(strtotime(get_post($postId)->post_date));
	}
}
