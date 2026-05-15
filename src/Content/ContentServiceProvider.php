<?php

/**
 * Content service provider.
 *
 * @author    Bifrost
 * @copyright Copyright (c) 2026
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/wptrainingteam/developer-showcase
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Content;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;

final class ContentServiceProvider extends ServiceProvider implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		$this->container->get(Category::class)->boot();
		$this->container->get(Page::class)->boot();
		$this->container->get(Post::class)->boot();
		$this->container->get(PostTag::class)->boot();
		$this->container->get(PostStatusManager::class )->boot();
	}
}
