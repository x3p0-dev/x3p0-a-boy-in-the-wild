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
use X3P0\ABoyInTheWild\Story\Chapter\ChapterRepository;

/**
 * Handles registering the `x3p0/chapter` block bindings source and rendering its
 * output based on the given arguments.
 */
final class Chapter extends BindingSource
{
	public const NAME = 'x3p0/chapter';

	protected const USES_CONTEXT = ['postId'];

	public function __construct(private readonly ChapterRepository $chapters) {}

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
	public function callback(array $args, WP_Block $block, string $name): ?string
	{
		$postId = absint($block->context['postId'] ?? get_the_ID());

		return $this->chapters->find($postId)?->field($args['field'] ?? '');
	}
}
