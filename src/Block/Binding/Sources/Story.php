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
use X3P0\ABoyInTheWild\Block\Binding\BindingSource;
use X3P0\ABoyInTheWild\Story\Chapter\{Chapter, ChapterRepository};

/**
 * Handles registering the `x3p0/story` block bindings source and rendering its
 * output based on the given arguments.
 */
final class Story extends BindingSource
{
	public const NAME = 'x3p0/story';

	/**
	 * Caches the first chapter for the request.
	 */
	private ?Chapter $firstChapter = null;

	public function __construct(private readonly ChapterRepository $chapters) {}

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
	public function callback(array $args, WP_Block $block, string $name): ?string
	{
		return match ($args['field'] ?? '') {
			'firstChapterUrl'   => $this->renderFirstChapterUrl(),
			'firstChapterLabel' => $this->renderFirstChapterLabel(),
			default             => null
		};
	}

	/**
	 * Returns the story's first chapter, resolved from the Chapter repository.
	 */
	private function getFirstChapter(): ?Chapter
	{
		return $this->firstChapter ??= $this->chapters->first();
	}

	/**
	 * Renders the first chapter's URL.
	 */
	private function renderFirstChapterUrl(): ?string
	{
		if (! $chapter = $this->getFirstChapter()) {
			return null;
		}

		return esc_url(get_permalink($chapter->post()->ID));
	}

	/**
	 * Renders the first chapter's label.
	 */
	private function renderFirstChapterLabel(): ?string
	{
		if (! $chapter = $this->getFirstChapter()) {
			return null;
		}

		return sprintf(
			__('Begin at %s &rarr;', 'x3p0-a-boy-in-the-wild'),
			esc_html(get_the_title($chapter->post()->ID))
		);
	}
}
