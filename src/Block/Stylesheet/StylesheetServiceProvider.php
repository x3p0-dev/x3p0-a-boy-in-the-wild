<?php

/**
 * Block stylesheet service provider.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Stylesheet;

use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;
use X3P0\ABoyInTheWild\Asset\AssetResolver;

final class StylesheetServiceProvider extends ServiceProvider
{
	private const STYLESHEETS_PATH = 'public/css/blocks';

	/**
	 * @inheritDoc
	 */
	protected const BOOTABLE = [
		StylesheetLoader::class
	];

	/**
	 * @inheritDoc
	 */
	public function register(): void
	{
		$this->container->singleton(
			StylesheetIterator::class,
			fn($container) => new StylesheetIterator(
				$container->get(AssetResolver::class),
				self::STYLESHEETS_PATH
			)
		);

		parent::register();
	}
}
