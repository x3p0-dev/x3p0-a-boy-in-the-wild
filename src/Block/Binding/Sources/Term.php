<?php

/**
 * Term data binding class.
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
use WP_Term;

/**
 * Handles registering the `x3p0/term` block bindings source and
 * rendering its output based on the given arguments.
 */
final class Term extends BindingSource
{
	protected const NAME = 'x3p0/term';

	/**
	 * @inheritDoc
	 */
	public function getLabel(): string
	{
		return __('Term Data', 'x3p0-a-boy-in-the-wild');
	}

	/**
	 * @inheritDoc
	 */
	public function callback(array $args, WP_Block $block, string $name): ?string
	{
		return match ($args['field'] ?? null) {
			'count' => $this->renderCount($args),
			default => null
		};
	}

	/**
	 * Helper function for getting the term object.
	 */
	private function getTerm(array $args): ?WP_Term
	{
		$term = isset($args['term'], $args['taxonomy'])
			? get_term_by('slug', $args['term'], $args['taxonomy'])
			: get_queried_object();

		return $term instanceof WP_Term ? $term : null;
	}

	/**
	 * Returns a term's published post count.
	 */
	private function renderCount(array $args): ?string
	{
		if (! $term = $this->getTerm($args)) {
			return null;
		}

		$postType = get_post_type_object(get_taxonomy($term->taxonomy)->object_type[0]);

		if (! $postType) {
			return null;
		}

		$total = $term->count;

		return sprintf(
			// Translators: 1: Number of posts, 2: Post type label (singular or plural)
			esc_html(_n('%1$s %2$s', '%1$s %2$s', $total, 'x3p0-a-boy-in-the-wild')),
			number_format_i18n($total),
			$total === 1 ? $postType->labels->singular_name : $postType->labels->name
		);
	}
}
