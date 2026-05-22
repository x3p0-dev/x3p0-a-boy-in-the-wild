<?php

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Admin;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;

final class AdminServiceProvider extends ServiceProvider implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		$this->container->get(AdminColorRegistrar::class)->boot();
	}
}
