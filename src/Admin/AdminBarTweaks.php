<?php

/**
 * Admin color scheme registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-ideas
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Admin;

use WP_Admin_Bar;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * ...
 */
final class AdminBarTweaks implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('admin_bar_menu', $this->adminBarMenu(...), 999999);
	}

	private function adminBarMenu(WP_Admin_Bar $wp_admin_bar): void
	{
		$node = $wp_admin_bar->get_node( 'my-account' );

		if ( ! $node ) {
			return;
		}

		$node->title = __( 'Still here, Adventurer', 'x3p0-a-boy-in-the-wild' );

		$wp_admin_bar->add_node( (array) $node );
	}
}
