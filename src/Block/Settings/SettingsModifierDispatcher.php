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

use Closure;
use ReflectionException;
use X3P0\ABoyInTheWild\Block\ForBlock;
use X3P0\ABoyInTheWild\Framework\Container\Attributes\DeferredTagged;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Hooks the single `block_type_metadata_settings` filter and dispatches it to
 * the settings modifier registered for the block being registered. The
 * modifiers are tagged in the container and injected here as deferred
 * resolvers, so each modifier is built only when its block is actually
 * registered, and this class stays free of the container.
 */
final class SettingsModifierDispatcher implements Bootable
{
	/**
	 * Map of block type to a closure that resolves its settings modifier.
	 *
	 * @var array<string, Closure(): SettingsModifier>
	 */
	private array $map = [];

	/**
	 * @param array<class-string, Closure(): SettingsModifier> $modifiers
	 */
	public function __construct(
		#[DeferredTagged('block.settings.modifiers')]
		private readonly array $modifiers
	) {}

	/**
	 * @inheritDoc
	 * @throws ReflectionException
	 */
	public function boot(): void
	{
		foreach ($this->modifiers as $class => $makeModifier) {
			$this->map[ForBlock::of($class)] = $makeModifier;
		}

		add_filter('block_type_metadata_settings', $this->modify(...), 999999);
	}

	/**
	 * Runs the registered modifier (if any) over the block's settings,
	 * resolving it from the container only at the moment it is needed.
	 */
	private function modify(array $settings): array
	{
		$makeModifier = $this->map[$settings['name'] ?? ''] ?? null;

		return $makeModifier ? $makeModifier()->modify($settings) : $settings;
	}
}
