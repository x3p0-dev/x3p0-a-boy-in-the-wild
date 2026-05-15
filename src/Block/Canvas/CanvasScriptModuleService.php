<?php

/**
 * Canvas script module service.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Canvas;

use WP_Block;
use WP_HTML_Tag_Processor;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Enqueues canvas script modules when their trigger class appears on a `<canvas>`
 * element inside a Custom HTML block.
 */
final class CanvasScriptModuleService implements Bootable
{
	public function __construct(private readonly CanvasScriptModuleRegistry $registry)
	{}

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_filter('render_block_core/html', $this->render(...), 10, 3);
	}

	/**
	 * Scans the rendered HTML block for canvas elements and enqueues any
	 * registered script modules whose trigger class is present.
	 */
	private function render(string $content, array $block, WP_Block $instance): string
	{
		$processor = new WP_HTML_Tag_Processor($content);

		while ($processor->next_tag('canvas')) {
			foreach ($this->registry->all() as $cssClass => $module) {
				if ($processor->has_class($cssClass)) {
					$this->enqueueModule($module['handle'], $module['src']);
				}
			}
		}

		return $content;
	}

	/**
	 * Enqueues a script module if its compiled asset file exists.
	 */
	private function enqueueModule(string $handle, string $src): void
	{
		$assetFile = get_theme_file_path(str_replace('.js', '.asset.php', $src));

		if (! file_exists($assetFile)) {
			return;
		}

		$asset = include $assetFile;

		wp_enqueue_script_module(
			$handle,
			get_theme_file_uri($src),
			$asset['dependencies'],
			$asset['version'],
			[ 'in_footer' => true, 'fetchpriority' => 'low' ]
		);
	}
}
