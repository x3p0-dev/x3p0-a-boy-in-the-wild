<?php

/**
 * Font Library disabler.
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
 * Disables the Font Library on the admin side by hiding its submenu link and
 * blocking direct access to its page.
 *
 * The editor-side flag that hides the Font Library within the block editor UI
 * lives separately in {@see \X3P0\ABoyInTheWild\Editor\EditorSettings}.
 */
final class FontLibraryDisabler implements Bootable
{
	/**
	 * Submenu slugs registered under Appearance for the Font Library. Core
	 * and the Gutenberg plugin register it under different slugs, so both
	 * are handled.
	 */
	private const MENU_SLUGS = [
		'font-library.php',     // WordPress core.
		'font-library-wp-admin' // Gutenberg plugin.
	];

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('admin_menu', $this->removeMenuPages(...), 999999);

		foreach (self::MENU_SLUGS as $slug) {
			$hook = str_replace('.php', '', $slug);
			add_action("load-appearance_page_{$hook}", $this->blockPage(...));
		}
	}

	/**
	 * Removes the Font Library submenu pages under Appearance.
	 */
	private function removeMenuPages(): void
	{
		foreach (self::MENU_SLUGS as $slug) {
			remove_submenu_page('themes.php', $slug);
		}
	}

	/**
	 * Blocks direct requests to a Font Library page, which remains
	 * reachable by URL even after its submenu link is removed.
	 */
	private function blockPage(): never
	{
		wp_die(
			esc_html__('This feature has been disabled.', 'x3p0-a-boy-in-the-wild'),
			esc_html__('Disabled', 'x3p0-a-boy-in-the-wild'),
			[ 'response' => 403, 'back_link' => true ]
		);
	}
}
