<?php

/**
 * Block settings modifier dispatcher.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Settings;

use ReflectionException;
use X3P0\ABoyInTheWild\Block\ForBlock;
use X3P0\ABoyInTheWild\Framework\Container\Attributes\Tagged;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Hooks the single `block_type_metadata_settings` filter and dispatches it to
 * the settings modifier registered for the block being registered. The
 * modifiers are composed and handed in by the service provider, so this class
 * stays free of the container.
 */
final class SettingsModifierDispatcher implements Bootable
{
	/**
	 * Map of block type to its settings modifier.
	 *
	 * @var array<string, SettingsModifier>
	 */
	private array $map = [];

	/**
	 * @param array<int, SettingsModifier> $modifiers The settings modifiers.
	 */
	public function __construct(
		#[Tagged('block.settings.modifiers')]
		private readonly array $modifiers
	) {}

	/**
	 * @inheritDoc
	 * @throws ReflectionException
	 */
	public function boot(): void
	{
		foreach ($this->modifiers as $modifier) {
			$this->map[ForBlock::of($modifier)] = $modifier;
		}

		add_filter('block_type_metadata_settings', $this->modify(...), 999999);
	}

	/**
	 * Runs the registered modifier (if any) over the block's settings.
	 */
	private function modify(array $settings): array
	{
		$modifier = $this->map[$settings['name'] ?? ''] ?? null;

		return $modifier ? $modifier->modify($settings) : $settings;
	}
}
