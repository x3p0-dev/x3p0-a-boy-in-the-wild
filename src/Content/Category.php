<?php

/**
 * Category taxonomy modifier.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Content;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Rebrands the built-in category taxonomy as "Eras" to match the narrative
 * framing of the theme.
 */
final class Category implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_filter('register_taxonomy_args', $this->taxonomyArgs(...), 999999, 2);
	}

	/**
	 * Filters the category taxonomy arguments to add custom labels.
	 */
	public function taxonomyArgs(array $args, string $taxonomy): array
	{
		if ('category' !== $taxonomy) {
			return $args;
		}

		$args['labels'] = array_merge($args['labels'] ?? [], [
			'name'          => __('Eras', 'x3p0-a-boy-in-the-wild'),
			'singular_name' => __('Era', 'x3p0-a-boy-in-the-wild'),
			'menu_name'     => __('Eras', 'x3p0-a-boy-in-the-wild'),
			'add_new_item'  => __('Add New Era', 'x3p0-a-boy-in-the-wild'),
			'edit_item'     => __('Edit Era', 'x3p0-a-boy-in-the-wild'),
			'update_item'   => __('Update Era', 'x3p0-a-boy-in-the-wild'),
			'search_items'  => __('Search Eras', 'x3p0-a-boy-in-the-wild'),
			'all_items'     => __('All Eras', 'x3p0-a-boy-in-the-wild'),
			'not_found'     => __('No eras found.', 'x3p0-a-boy-in-the-wild'),
			'no_terms'      => __('No eras', 'x3p0-a-boy-in-the-wild'),
		]);

		return $args;
	}
}
