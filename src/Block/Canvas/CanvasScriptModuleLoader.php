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

/**
 * Enqueues canvas script modules when a matching BEM modifier class is found
 * on a `<canvas>` element inside a Custom HTML block.
 *
 * The CSS class is the contract: `x3p0-canvas-{namespace}--{slug}` triggers
 * the matching `public/js/canvas/{namespace}/{slug}.js` module if its built
 * `.asset.php` file exists.
 */
final class CanvasScriptModuleLoader implements Bootable
{
	/**
	 * CSS class prefix used to detect a module on a canvas element.
	 */
	private const CSS_PREFIX = 'x3p0-canvas';

	/**
	 * Handle prefix used for registering script modules.
	 */
	private const HANDLE_PREFIX = 'x3p0/canvas';

	/**
	 * Theme-relative path where canvas modules live.
	 */
	private const FILE_PREFIX = 'public/js/canvas';

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('init', $this->registerSharedModules(...));
		add_filter('render_block_core/html', $this->render(...));
	}

	/**
	 * Registers the shared utils module so scene modules can import it via
	 * the bare specifier `x3p0/canvas-utils`. Each scene's compiled asset
	 * file lists this handle in its dependencies array; WordPress emits the
	 * matching import map entry and recursively enqueues this module when
	 * a scene that depends on it is enqueued.
	 */
	private function registerSharedModules(): void
	{
		$path      = self::FILE_PREFIX . '/utils';
		$assetFile = get_parent_theme_file_path("{$path}.asset.php");

		if (! file_exists($assetFile)) {
			return;
		}

		$asset = include $assetFile;

		wp_register_script_module(
			'x3p0/canvas-utils',
			get_parent_theme_file_uri("{$path}.js"),
			$asset['dependencies'],
			$asset['version'],
			[ 'in_footer' => true, 'fetchpriority' => 'low' ]
		);
	}

	/**
	 * Scans the rendered HTML block for canvas elements and enqueues any
	 * script modules whose trigger class is present.
	 */
	private function render(string $content): string
	{
		$processor = new WP_HTML_Tag_Processor($content);

		while ($processor->next_tag('canvas')) {
			foreach ($this->matchedModules($processor) as [$namespace, $slug]) {
				$this->enqueueModule($namespace, $slug);
			}
		}

		return $content;
	}

	/**
	 * Yields (namespace, slug) pairs parsed from the current canvas element's
	 * classes. A class like `x3p0-canvas-scene--motes` yields
	 * `['scene', 'motes']`.
	 *
	 * @return iterable<array{0: string, 1: string}>
	 */
	private function matchedModules(WP_HTML_Tag_Processor $processor): iterable
	{
		$prefix = self::CSS_PREFIX . '-';

		foreach ($processor->class_list() as $class) {
			if (! str_starts_with($class, $prefix)) {
				continue;
			}

			$remainder = substr($class, strlen($prefix));

			if (! str_contains($remainder, '--')) {
				continue;
			}

			[$namespace, $slug] = explode('--', $remainder, 2);

			if ($namespace === '' || $slug === '') {
				continue;
			}

			yield [$namespace, $slug];
		}
	}

	/**
	 * Enqueues a script module if its compiled asset file exists.
	 */
	private function enqueueModule(string $namespace, string $slug): void
	{
		$path      = self::FILE_PREFIX . "/{$namespace}/{$slug}";
		$assetFile = get_parent_theme_file_path("{$path}.asset.php");

		if (! file_exists($assetFile)) {
			return;
		}

		$asset = include $assetFile;

		wp_enqueue_script_module(
			self::HANDLE_PREFIX . "-{$namespace}-{$slug}",
			get_parent_theme_file_uri("{$path}.js"),
			$asset['dependencies'],
			$asset['version'],
			[ 'in_footer' => true, 'fetchpriority' => 'low' ]
		);
	}
}
