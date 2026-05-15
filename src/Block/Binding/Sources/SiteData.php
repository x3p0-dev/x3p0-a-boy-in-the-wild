<?php

/**
 * Site binding class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding\Sources;

use WP_Block;
use X3P0\ABoyInTheWild\Block\Binding\BindingSource;

/**
 * Handles registering the `x3p0/site-data` block bindings source and rendering its
 * output based on the given arguments.
 */
final class SiteData extends BindingSource
{
	protected const NAME = 'x3p0/site-data';

	/**
	 * @inheritDoc
	 */
	public function getLabel(): string
	{
		return __('Site Data', 'x3p0-a-boy-in-the-wild');
	}

	/**
	 * @inheritDoc
	 */
	public function callback(array $args, WP_Block $block, string $name): ?string
	{
		return match ($args['field'] ?? '') {
			'url'    => home_url(),
			default  => null
		};
	}
}
