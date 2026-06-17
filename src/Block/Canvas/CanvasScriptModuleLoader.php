<?php

/**
 * Canvas script module loader.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Canvas;

use WP_HTML_Tag_Processor;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Support\CompiledAsset;

/**
 * Enqueues canvas script modules when a matching trigger class is found on a
 * `<canvas>` element inside a Custom HTML block.
 *
 * The {@see Canvas} enum is the contract: a class like `x3p0-canvas-scene--motes`
 * resolves to the `Canvas::SceneMotes` case, which is enqueued if its built
 * `.asset.php` file exists. Classes that do not resolve to a case are ignored.
 */
final class CanvasScriptModuleLoader implements Bootable
{
	/**
	 * Shared utility module handles and their file paths.
	 */
	private const SHARED_MODULES = [
		'x3p0/canvas-utils' => 'public/js/canvas/utils.js'
	];

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('init', $this->registerSharedModules(...));
		add_filter('render_block_core/html', $this->render(...));
	}

	/**
	 * Registers shared modules so scene modules can import them via the
	 * bare specifier (e.g., `x3p0/canvas-utils`). Each scene's compiled
	 * asset file lists the handles in its dependencies array; WordPress
	 * emits the matching import map entry and recursively enqueues these
	 * modules when a scene that depends on them is enqueued.
	 */
	private function registerSharedModules(): void
	{
		foreach (self::SHARED_MODULES as $handle => $path) {
			$module = new CompiledAsset($path);

			if (! $module->hasAssetFile()) {
				return;
			}

			wp_register_script_module(
				$handle,
				$module->fileUrl(),
				$module->dependencies(),
				$module->version(),
				[ 'in_footer' => true, 'fetchpriority' => 'low' ]
			);
		}
	}

	/**
	 * Scans the rendered HTML block for canvas elements and enqueues any
	 * script modules whose trigger class is present.
	 */
	private function render(string $content): string
	{
		// Bail early if in the admin, which can trigger this hook.
		if (is_admin()) {
			return $content;
		}

		$processor = new WP_HTML_Tag_Processor($content);

		while ($processor->next_tag('canvas')) {
			foreach ($this->matchedModules($processor) as $canvas) {
				$this->enqueueModule($canvas);
			}
		}

		return $content;
	}

	/**
	 * Yields the {@see Canvas} case for each trigger class on the current
	 * canvas element. Classes that do not resolve to a case are skipped.
	 *
	 * @return iterable<Canvas>
	 */
	private function matchedModules(WP_HTML_Tag_Processor $processor): iterable
	{
		/* @var string $class */
		foreach ($processor->class_list() as $class) {
			$canvas = Canvas::fromModifierClass($class);

			if ($canvas instanceof Canvas) {
				yield $canvas;
			}
		}
	}

	/**
	 * Enqueues a script module if its compiled asset file exists.
	 */
	private function enqueueModule(Canvas $canvas): void
	{
		$module = $canvas->module();

		if (! $module->hasAssetFile()) {
			return;
		}

		wp_enqueue_script_module(
			$canvas->handle(),
			$module->fileUrl(),
			$module->dependencies(),
			$module->version(),
			[ 'in_footer' => true, 'fetchpriority' => 'low' ]
		);
	}
}
