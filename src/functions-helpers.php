<?php

/**
 * The helpers functions file houses any necessary PHP functions for the theme.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild;

use X3P0\ABoyInTheWild\Framework\Container\{Container, ServiceContainer};

/**
 * Returns the theme application instance.
 */
function theme(): Theme
{
	static $theme = null;

	return $theme ??= new Theme(new ServiceContainer());
}


/**
 * Helper function for quickly accessing the service container. Devs can access
 * any concrete implementation by passing in a reference to its abstract
 * identifier via `container()->get($abstract)`.
 */
function container(): Container
{
	return theme()->container();
}
