<?php

/**
 * Abstract render filter.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Render;

use WP_Block;

/**
 * The render filter contract defines how block render filters are implemented
 * within the theme. Each filter declares the block it targets via the
 * `#[ForBlock]` attribute; the subscriber reads that attribute and hooks the
 * `render()` method onto the `render_block_{type}` filter.
 */
abstract class RenderFilter
{
	/**
	 * Filter on the block's rendering process.
	 */
	abstract public function render(string $content, array $block, WP_Block $instance): string;
}
