<?php

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Template;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;

final class TemplateServiceProvider extends ServiceProvider implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		$this->container->get(TemplateHierarchy::class)->boot();
		$this->container->get(TemplateRegistrar::class)->boot();
	}
}
