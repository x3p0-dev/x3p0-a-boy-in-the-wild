<?php

/**
 * Site binding class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding\Sources;

use WP_Block;
use X3P0\ABoyInTheWild\Block\Binding\BindingSource;
use X3P0\ABoyInTheWild\Support\Season;

/**
 * Handles registering the `x3p0/site-data` block bindings source and rendering its
 * output based on the given arguments.
 */
final class PostData extends BindingSource
{
	protected const NAME = 'x3p0/post-data';

	/**
	 * Stores the post ID.
	 */
	private int $postId = 0;

	/**
	 * @inheritDoc
	 */
	public function getLabel(): string
	{
		return __('Post Data', 'x3p0-ideas');
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
		$this->postId = $block->context['postId'] ?? get_the_ID();

		return match ($args['field'] ?? '') {
			'url'    => get_permalink($this->postId),
			'season' => Season::seasonFromDate(strtotime(get_post($this->postId)->post_date)),
			default  => null
		};
	}
}
