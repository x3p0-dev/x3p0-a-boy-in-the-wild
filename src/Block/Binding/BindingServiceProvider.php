<?php

/**
 * Block bindings service provider.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding;

use X3P0\ABoyInTheWild\Framework\Container\Container;
use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;

/**
 * Boots the bindings registered under the Block Binding domain.
 */
final class BindingServiceProvider extends ServiceProvider
{
	/**
	 * Block binding source classnames. Resolved from the container so each
	 * source receives its own dependencies via constructor injection.
	 */
	private const SOURCES = [
		Sources\Chapter::class,
		Sources\Query::class,
		Sources\Site::class,
		Sources\Story::class,
		Sources\Term::class
	];

	protected const BOOTABLE = [
		BindingSourceRegistrar::class
	];

	/**
	 * @inheritDoc
	 */
	public function register(): void
	{
		parent::register();

		$this->container->singleton(
			BindingSourceRegistrar::class,
			fn (Container $container) => new BindingSourceRegistrar(
				array_map($container->get(...), self::SOURCES)
			)
		);
	}
}
