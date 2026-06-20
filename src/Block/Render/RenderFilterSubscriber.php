<?php

/**
 * Block render filter subscriber.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Render;

use ReflectionException;
use X3P0\ABoyInTheWild\Block\ForBlock;
use X3P0\ABoyInTheWild\Framework\Container\Attributes\Tagged;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Subscribes render filters to the per-block `render_block_{type}` filter. The
 * filters are composed and handed in by the service provider, so this class
 * stays free of the container.
 */
final class RenderFilterSubscriber implements Bootable
{
	/**
	 * @param array<int, RenderFilter> $filters The render filters to subscribe.
	 */
	public function __construct(
		#[Tagged('block.render.filters')]
		private readonly array $filters
	) {}

	/**
	 * @inheritDoc
	 * @throws ReflectionException
	 */
	public function boot(): void
	{
		foreach ($this->filters as $filter) {
			add_filter(
				'render_block_' . ForBlock::of($filter),
				$filter->render(...),
				999999,
				3
			);
		}
	}
}
