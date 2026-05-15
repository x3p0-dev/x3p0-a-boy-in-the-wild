<?php

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Pattern;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;

final class PatternServiceProvider extends ServiceProvider implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		$this->container->get(PatternCategoryRegistrar::class)->boot();
		$this->container->get(PatternRegistrar::class)->boot();
	}
}
