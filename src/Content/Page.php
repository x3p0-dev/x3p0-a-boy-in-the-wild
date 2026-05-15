<?php

/**
 * Post content service.
 *
 * @author    Bifrost
 * @copyright Copyright (c) 2026
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/wptrainingteam/developer-showcase
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Content;

use WP_Post;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Support\Season;

final class Page implements Bootable
{
	/**
	 * {@inheritDoc}
	 */
	public function boot(): void
	{
		add_filter('register_post_type_args', $this->postTypeArgs(...), 999999, 2);
	}

	private function postTypeArgs(array $args, string $postType): array
	{
		if ('page' !== $postType) {
			return $args;
		}

		$args['menu_icon'] = 'dashicons-location-alt';

		$args['labels'] = [
			'name'                     => _x( 'Waymarks', 'post type general name', 'x3p0-a-boy-in-the-wild' ),
			'singular_name'            => _x( 'Waymark', 'post type singular name', 'x3p0-a-boy-in-the-wild' ),
			'add_new'                  => __( 'New Waymark', 'x3p0-a-boy-in-the-wild' ),
			'add_new_item'             => __( 'New Waymark', 'x3p0-a-boy-in-the-wild' ),
			'edit_item'                => __( 'Edit Waymark', 'x3p0-a-boy-in-the-wild' ),
			'new_item'                 => __( 'New Waymark', 'x3p0-a-boy-in-the-wild' ),
			'view_item'                => __( 'View Waymark', 'x3p0-a-boy-in-the-wild' ),
			'view_items'               => __( 'View Waymarks', 'x3p0-a-boy-in-the-wild' ),
			'search_items'             => __( 'Search Waymarks', 'x3p0-a-boy-in-the-wild' ),
			'not_found'                => __( 'No waymarks found.', 'x3p0-a-boy-in-the-wild' ),
			'not_found_in_trash'       => __( 'No waymarks in the archive.', 'x3p0-a-boy-in-the-wild' ),
			'parent_item_colon'        => __( 'Parent Waymark:', 'x3p0-a-boy-in-the-wild' ),
			'all_items'                => __( 'All Waymarks', 'x3p0-a-boy-in-the-wild' ),
			'archives'                 => __( 'Waymarks', 'x3p0-a-boy-in-the-wild' ),
			'attributes'               => __( 'Waymark Attributes', 'x3p0-a-boy-in-the-wild' ),
			'insert_into_item'         => __( 'Insert into waymark', 'x3p0-a-boy-in-the-wild' ),
			'uploaded_to_this_item'    => __( 'Uploaded to this waymark', 'x3p0-a-boy-in-the-wild' ),
			'featured_image'           => _x( 'The Setting', 'waymark', 'x3p0-a-boy-in-the-wild' ),
			'set_featured_image'       => _x( 'Set the setting', 'waymark', 'x3p0-a-boy-in-the-wild' ),
			'remove_featured_image'    => _x( 'Remove the setting', 'waymark', 'x3p0-a-boy-in-the-wild' ),
			'use_featured_image'       => _x( 'Use as setting image', 'waymark', 'x3p0-a-boy-in-the-wild' ),
			'menu_name'                => _x( 'Waymarks', 'admin menu', 'x3p0-a-boy-in-the-wild' ),
			'filter_items_list'        => __( 'Filter waymarks list', 'x3p0-a-boy-in-the-wild' ),
			'filter_by_date'           => __( 'Filter by date', 'x3p0-a-boy-in-the-wild' ),
			'items_list_navigation'    => __( 'Waymarks list navigation', 'x3p0-a-boy-in-the-wild' ),
			'items_list'               => __( 'Waymarks list', 'x3p0-a-boy-in-the-wild' ),
			'item_published'           => __( 'Waymark published.', 'x3p0-a-boy-in-the-wild' ),
			'item_published_privately' => __( 'Waymark published privately.', 'x3p0-a-boy-in-the-wild' ),
			'item_reverted_to_draft'   => __( 'Waymark reverted to draft.', 'x3p0-a-boy-in-the-wild' ),
			'item_scheduled'           => __( 'Waymark scheduled.', 'x3p0-a-boy-in-the-wild' ),
			'item_updated'             => __( 'Waymark updated.', 'x3p0-a-boy-in-the-wild' ),
			'item_link'                => _x( 'Waymark Link', 'navigation link block title', 'x3p0-a-boy-in-the-wild' ),
			'item_link_description'    => _x( 'A link to a waymark.', 'navigation link block description', 'x3p0-a-boy-in-the-wild' ),
		];

		return $args;
	}
}
