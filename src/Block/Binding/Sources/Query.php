<?php

/**
 * Search data binding class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding\Sources;

use WP_Block;
use X3P0\ABoyInTheWild\Block\Binding\BindingSource;
use WP_Query;
use WP_Term;

/**
 * Handles registering the `x3p0/query` block bindings source and
 * rendering its output based on the given arguments.
 */
final class Query extends BindingSource
{
	protected const NAME = 'x3p0/query';

	/**
	 * @inheritDoc
	 */
	public function getLabel(): string
	{
		return __('Query Data', 'x3p0-a-boy-in-the-wild');
	}

	/**
	 * @inheritDoc
	 */
	public function callback(array $args, WP_Block $block, string $name): ?string
	{
		return match ($args['field'] ?? null) {
			'count' => $this->renderCount(),
			default  => null
		};
	}

	/**
	 * Returns the search results count.
	 */
	private function renderCount(): ?string
	{
		$total = absint($GLOBALS['wp_query']->found_posts);

		return sprintf(
			// Translators: 1: Number of found posts for a query.
			esc_html(_n('%1$s Chapter', '%1$s Chapters', $total, 'x3p0-a-boy-in-the-wild')),
			number_format_i18n($total)
		);
	}
}
