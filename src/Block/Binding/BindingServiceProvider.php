<?php

/**
 * Block bindings service provider.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding;

use WP_Block_Bindings_Registry;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;

final class BindingServiceProvider extends ServiceProvider implements Bootable
{
	/**
	 * Array of block binding source classnames.
	 */
	private const SOURCES = [
		Sources\Post::class,
		Sources\Query::class,
		Sources\Site::class,
		Sources\Story::class,
		Sources\Term::class
	];

	/**
	 * @inheritDoc
	 */
	public function register(): void
	{
		$this->container->singleton(
			BindingSourceRegistrar::class,
			fn() => new BindingSourceRegistrar(self::SOURCES)
		);
	}

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		$this->container->get(BindingSourceRegistrar::class)->boot();
	}
}
