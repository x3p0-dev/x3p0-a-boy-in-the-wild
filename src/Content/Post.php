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

namespace X3P0\ABoyInTheWild\Content;

use WP_Post;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Support\StorySeason;

final class Post implements Bootable
{
	/**
	 * {@inheritDoc}
	 */
	public function boot(): void
	{
		add_filter('register_post_type_args', $this->postTypeArgs(...), 999999, 2);
		add_filter('manage_posts_columns',    $this->managePostsColumns(...));
		add_filter('post_row_actions',        $this->postRowActions(...), 10, 2);
		add_filter('post_date_column_time',   $this->postDateColumnTime(...), 10, 4);
		add_filter('post_date_column_status', $this->postDateColumnStatus(...), 10, 4);
	}

	/**
	 * Filters the `post` post type arguments to add custom labels.
	 */
	private function postTypeArgs(array $args, string $postType): array
	{
		if ('post' !== $postType) {
			return $args;
		}

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

	private function postDateColumnStatus(string $status, WP_Post $post, string $column_name, string $mode): string
	{
		if ('post' !== $post->post_type) {
			return $status;
		}

		return '';
	}

	private function postDateColumnTime(string $h_time, WP_Post $post, string $column_name, string $mode): string
	{
		if ('post' !== $post->post_type) {
			return $h_time;
		}

		// The filter fires twice when post_modified differs from post_date.
		// Only render on the first (published) call.
		if ($post->post_modified !== $post->post_date && strtotime($h_time) === strtotime($post->post_modified)) {
			return '';
		}

		$timestamp = strtotime($post->post_date);

		if (! $timestamp) {
			return $h_time;
		}

		$season = StorySeason::seasonFromDate($timestamp);
		$date   = date_i18n(get_option('date_format'), $timestamp);

		return esc_html($season) . '<br>' . esc_html($date);
	}

	private function managePostsColumns(array $columns): array
	{
		if (isset($columns['author'])) {
			$columns['author'] = __('Narrator', 'x3p0-a-boy-in-the-wild');
		}

		if (isset($columns['title'])) {
			$columns['title'] = __('Chapter', 'x3p0-a-boy-in-the-wild');
		}

		if (isset($columns['date'])) {
			$columns['date'] = __('Season', 'x3p0-a-boy-in-the-wild');
		}

		return $columns;
	}

	private function postRowActions(array $actions, WP_Post $post): array
	{
		if (isset($actions['edit'])) {
			$actions['edit'] = str_replace(
				'Edit',
				__('Edit Chapter', 'x3p0-a-boy-in-the-wild'),
				$actions['edit']
			);
		}

		if (isset($actions['trash'])) {
			$actions['trash'] = str_replace(
				'Trash',
				__('Mark as Lost', 'x3p0-a-boy-in-the-wild'),
				$actions['trash']
			);
		}

		if (isset($actions['view'])) {
			$actions['view'] = str_replace(
				'View',
				__('Read Chapter', 'x3p0-a-boy-in-the-wild'),
				$actions['view']
			);
		}

		return $actions;
	}
}
