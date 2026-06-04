<?php

/**
 * Post content service.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Content\PostType;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Rebrands the built-in post type as "Chapters".
 */
final class Post implements Bootable
{
	/**
	 * {@inheritDoc}
	 */
	public function boot(): void
	{
		add_filter('register_post_post_type_args', $this->filter(...), 999999, 2);
	}

	/**
	 * Filters the `post` post type arguments to add custom labels.
	 */
	private function filter(array $args, string $postType): array
	{
		$args['menu_icon'] = 'dashicons-book-alt';

		$args['labels'] = [
			'name'                     => _x('Chapters', 'post type general name', 'x3p0-a-boy-in-the-wild'),
			'singular_name'            => _x('Chapter', 'post type singular name', 'x3p0-a-boy-in-the-wild'),
			'add_new'                  => __('Add New', 'x3p0-a-boy-in-the-wild'),
			'add_new_item'             => __('Add New Chapter', 'x3p0-a-boy-in-the-wild'),
			'edit_item'                => __('Edit Chapter', 'x3p0-a-boy-in-the-wild'),
			'new_item'                 => __('New Chapter', 'x3p0-a-boy-in-the-wild'),
			'view_item'                => __('View Chapter', 'x3p0-a-boy-in-the-wild'),
			'view_items'               => __('View Chapters', 'x3p0-a-boy-in-the-wild'),
			'search_items'             => __('Search Chapters', 'x3p0-a-boy-in-the-wild'),
			'not_found'                => __('No chapters found.', 'x3p0-a-boy-in-the-wild'),
			'not_found_in_trash'       => __('No chapters found in Trash.', 'x3p0-a-boy-in-the-wild'),
			'parent_item_colon'        => __('Parent Chapter:', 'x3p0-a-boy-in-the-wild'),
			'all_items'                => __('All Chapters', 'x3p0-a-boy-in-the-wild'),
			'archives'                 => __('Chapter Archives', 'x3p0-a-boy-in-the-wild'),
			'attributes'               => __('Chapter Attributes', 'x3p0-a-boy-in-the-wild'),
			'insert_into_item'         => __('Insert into chapter', 'x3p0-a-boy-in-the-wild'),
			'uploaded_to_this_item'    => __('Uploaded to this chapter', 'x3p0-a-boy-in-the-wild'),
			'featured_image'           => _x('Featured Image', 'chapter', 'x3p0-a-boy-in-the-wild'),
			'set_featured_image'       => _x('Set featured image', 'chapter', 'x3p0-a-boy-in-the-wild'),
			'remove_featured_image'    => _x('Remove featured image', 'chapter', 'x3p0-a-boy-in-the-wild'),
			'use_featured_image'       => _x('Use as featured image', 'chapter', 'x3p0-a-boy-in-the-wild'),
			'menu_name'                => _x('Story', 'admin menu', 'x3p0-a-boy-in-the-wild'),
			'filter_items_list'        => __('Filter chapters list', 'x3p0-a-boy-in-the-wild'),
			'filter_by_date'           => __('Filter by date', 'x3p0-a-boy-in-the-wild'),
			'items_list_navigation'    => __('Chapters list navigation', 'x3p0-a-boy-in-the-wild'),
			'items_list'               => __('Chapters list', 'x3p0-a-boy-in-the-wild'),
			'item_published'           => __('Chapter published.', 'x3p0-a-boy-in-the-wild'),
			'item_published_privately' => __('Chapter published privately.', 'x3p0-a-boy-in-the-wild'),
			'item_reverted_to_draft'   => __('Chapter reverted to draft.', 'x3p0-a-boy-in-the-wild'),
			'item_scheduled'           => __('Chapter scheduled.', 'x3p0-a-boy-in-the-wild'),
			'item_updated'             => __('Chapter updated.', 'x3p0-a-boy-in-the-wild'),
			'item_link'                => _x('Chapter Link', 'navigation link block title', 'x3p0-a-boy-in-the-wild'),
			'item_link_description'    => _x('A link to a chapter.', 'navigation link block description', 'x3p0-a-boy-in-the-wild'),
		];

		return $args;
	}
}
