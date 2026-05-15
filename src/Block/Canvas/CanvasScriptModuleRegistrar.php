<?php

/**
 * Canvas script module registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Canvas;

/**
 * Registers the default canvas script modules with the registry.
 *
 * Slugs are grouped by their canvas type, which maps to the CSS class modifier
 * (e.g., `bg` → `x3p0-canvas-bg--{slug}`). All other data — the handle and
 * src path — are derived from the group and slug at registration time.
 */
final class CanvasScriptModuleRegistrar
{
	/**
	 * Canvas slugs grouped by type.
	 *
	 * @var array<string, string[]>
	 */
	private const MODULES = [
		'bg' => [
			'flow-field',
			'lost-moon',
			'lost-motes',
			'lost-terrain',
			'motes',
			'rising-embers',
			'snow-embers',
			'storm'
		],
	];

	/**
	 * Registers default modules with the registry.
	 */
	public static function register(CanvasScriptModuleRegistry $registry): void
	{
		foreach (self::MODULES as $type => $slugs) {
			foreach ($slugs as $slug) {
				if (! $registry->has($type, $slug)) {
					$registry->add($type, $slug);
				}
			}
		}
	}
}
