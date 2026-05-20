<?php

/**
 * Block render service provider.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Render;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;

final class RenderServiceProvider extends ServiceProvider implements Bootable
{
	/**
	 * Classes that hook into specific block's rendering process.
	 */
	private const RENDERERS = [
		Filters\Button::class,
		Filters\PostExcerpt::class
	];

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		foreach (self::RENDERERS as $renderer) {
			$this->container->get($renderer)->boot();
		}
	}
}
