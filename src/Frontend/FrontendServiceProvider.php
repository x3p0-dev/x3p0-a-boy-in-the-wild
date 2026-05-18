<?php

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Frontend;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;

final class FrontendServiceProvider extends ServiceProvider implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		$this->container->get(FrontendAssets::class)->boot();
		$this->container->get(FrontendQuery::class)->boot();
		$this->container->get(FrontendTweaks::class)->boot();
	}
}
