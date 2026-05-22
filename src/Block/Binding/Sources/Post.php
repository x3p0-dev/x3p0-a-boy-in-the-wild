<?php

/**
 * Post binding class.
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
use X3P0\ABoyInTheWild\Support\StorySeason;

/**
 * Handles registering the `x3p0/post` block bindings source and rendering its
 * output based on the given arguments.
 */
final class Post extends BindingSource
{
	protected const NAME = 'x3p0/post';

	/**
	 * @inheritDoc
	 */
	public function getLabel(): string
	{
		return __('Post Data', 'x3p0-a-boy-in-the-wild');
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
		$postId = $block->context['postId'] ?? get_the_ID();

		return match ($args['field'] ?? '') {
			'url'    => get_permalink($postId),
			'season' => StorySeason::seasonFromDate(strtotime(get_post($postId)->post_date)),
			default  => null
		};
	}
}
