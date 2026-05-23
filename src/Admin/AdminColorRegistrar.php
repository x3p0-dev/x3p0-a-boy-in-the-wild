<?php

/**
 * Admin color scheme registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Admin;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Registers custom admin color schemes for the theme.
 */
final class AdminColorRegistrar implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('admin_init', $this->register(...));
	}

	/**
	 * Registers the custom admin color scheme with WordPress.
	 */
	private function register(): void
	{
		wp_admin_css_color(
			'x3p0-a-boy-in-the-wild-admin-in-the-field',
			__('In the Field', 'x3p0-a-boy-in-the-wild'),
			get_theme_file_uri('public/css/admin/in-the-field.css'),
			[ '#2c2418', '#5c3d1e', '#9a6b2e', '#c8a85a' ],
			[
				'base'    => '#d4b896',
				'focus'   => '#e8d5b0',
				'current' => '#f5ead0'
			]
		);
	}
}
