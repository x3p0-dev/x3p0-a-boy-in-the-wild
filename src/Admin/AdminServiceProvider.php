<?php

/**
 * Admin service provider.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Admin;

use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;

/**
 * Boots the bindings registered under the Admin domain.
 */
final class AdminServiceProvider extends ServiceProvider
{
	protected const BOOTABLE = [
		AdminColorRegistrar::class
	];
}
