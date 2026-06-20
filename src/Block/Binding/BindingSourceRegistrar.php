<?php

/**
 * Block bindings source registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding;

use LogicException;
use X3P0\ABoyInTheWild\Framework\Container\Attributes\Tagged;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Registers custom binding sources via the WordPress Block Bindings API. The
 * sources are composed and handed in by the service provider, so this class
 * stays free of the container.
 */
final class BindingSourceRegistrar implements Bootable
{
	/**
	 * @param array<int, BindingSource> $sources The binding sources to register.
	 */
	public function __construct(
		#[Tagged('block.binding.sources')]
		private readonly array $sources
	) {}

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('init', $this->register(...));
	}

	/**
	 * Register custom block bindings sources.
	 */
	public function register(): void
	{
		foreach ($this->sources as $source) {
			if ($source::NAME === '') {
				throw new LogicException(sprintf(
					// Translators: %s is a PHP classname.
					__('%s must define the NAME constant', 'x3p0-a-boy-in-the-wild'),
					$source::class
				));
			}

			register_block_bindings_source($source::NAME, [
				'label'              => $source->getLabel(),
				'get_value_callback' => $source->callback(...),
				'uses_context'       => $source->usesContext()
			]);
		}
	}
}
