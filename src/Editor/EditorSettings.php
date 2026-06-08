<?php

/**
 * Editor settings class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Editor;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Configures editor settings.
 */
final class EditorSettings implements Bootable
{
	/**
	 * Custom block editor settings to merge into the defaults.
	 *
	 * The `fontLibraryEnabled` flag hides the Font Library within the
	 * editor UI only. The admin-side menu link and page are disabled
	 * separately in {@see \X3P0\ABoyInTheWild\Admin\FontLibraryDisabler}.
	 */
	private const SETTINGS = [
		'disableContentOnlyForUnsyncedPatterns' => true,
		'fontLibraryEnabled'                    => false
	];

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_filter('block_editor_settings_all', $this->settings(...));
	}

	/**
	 * Customizes the block editor settings to enable/disable specific
	 * features that we do/don't need.
	 */
	private function settings(array $settings): array
	{
		return array_merge($settings, self::SETTINGS);
	}
}
