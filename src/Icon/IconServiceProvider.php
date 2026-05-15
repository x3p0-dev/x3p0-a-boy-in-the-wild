<?php

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Icon;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;

final class IconServiceProvider extends ServiceProvider implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		$this->container->get(IconRegistrar::class)->boot();
	}
}
