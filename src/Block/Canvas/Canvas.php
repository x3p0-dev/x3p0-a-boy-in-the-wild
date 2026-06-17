<?php

/**
 * Canvas module enum.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Canvas;

use X3P0\ABoyInTheWild\Support\CompiledAsset;

/**
 * Enum of canvas script modules bundled with the theme. Each case value is the
 * `{namespace}/{slug}` path fragment shared by the module's built files and its
 * CSS-class contract. The enum is the single source of truth: patterns emit a
 * canvas class via `classes()`, and the loader resolves a matched class back to
 * a case via `fromModifierClass()`. A class that is not a case never loads.
 */
enum Canvas: string
{
	case SceneAdrift       = 'scene/adrift';
	case SceneFlowField    = 'scene/flow-field';
	case SceneLostMoon     = 'scene/lost-moon';
	case SceneLostMotes    = 'scene/lost-motes';
	case SceneLostTerrain  = 'scene/lost-terrain';
	case SceneMotes        = 'scene/motes';
	case SceneRisingEmbers = 'scene/rising-embers';
	case SceneSmoke        = 'scene/smoke';
	case SceneSnowEmbers   = 'scene/snow-embers';
	case SceneSnowfall     = 'scene/snowfall';
	case SceneStorm        = 'scene/storm';

	/**
	 * CSS class prefix that marks a canvas element as a module trigger.
	 */
	private const CLASS_PREFIX = 'x3p0-canvas';

	/**
	 * Handle prefix used when registering the script module.
	 */
	private const HANDLE_PREFIX = 'x3p0/canvas';

	/**
	 * Theme-relative folder where the built canvas modules live.
	 */
	private const PATH = 'public/js/canvas';

	/**
	 * Resolves a single CSS class to its matching case, or `null` if the
	 * class is not a module trigger. A trigger looks like
	 * `x3p0-canvas-scene--motes`: the `x3p0-canvas-` prefix, then a
	 * `{namespace}--{slug}` modifier. The base class (`x3p0-canvas-scene`)
	 * and any unknown modifier resolve to `null`.
	 */
	public static function fromModifierClass(string $class): ?self
	{
		$prefix = self::CLASS_PREFIX . '-';

		if (! str_starts_with($class, $prefix)) {
			return null;
		}

		$remainder = substr($class, strlen($prefix));

		if (! str_contains($remainder, '--')) {
			return null;
		}

		[$namespace, $slug] = explode('--', $remainder, 2);

		if ($namespace === '' || $slug === '') {
			return null;
		}

		return self::tryFrom("{$namespace}/{$slug}");
	}

	/**
	 * Returns the full class list for the module's canvas element: the
	 * namespace base class plus the module modifier, e.g.
	 * `x3p0-canvas-scene x3p0-canvas-scene--motes`.
	 */
	public function classes(): string
	{
		[$namespace] = explode('/', $this->value, 2);

		return sprintf(
			'%1$s-%2$s %1$s-%3$s',
			self::CLASS_PREFIX,
			$namespace,
			str_replace('/', '--', $this->value)
		);
	}

	/**
	 * Returns the script module handle, e.g. `x3p0/canvas-scene-motes`.
	 */
	public function handle(): string
	{
		return self::HANDLE_PREFIX . '-' . str_replace('/', '-', $this->value);
	}

	/**
	 * Returns the compiled asset (built `.js` file and its `.asset.php`
	 * sidecar) for this module.
	 */
	public function module(): CompiledAsset
	{
		return new CompiledAsset(self::PATH . "/{$this->value}.js");
	}
}
