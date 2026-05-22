<?php

/**
 * Post type modifier manager.
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

/**
 * Manages the modification of post type settings during WordPress registration.
 *
 * This manager acts as a coordinator between the post type modifier registry and
 * factory. It hooks into WordPress's CPT registration process and applies
 * custom modifications to CPT args when a modifier is registered for that type.
 */
final class PostStatus implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('init', $this->modify(...), 999999);
		add_filter('display_post_states', $this->displayPostStates(...), 10, 2);
	}

	/**
	 * Modifies the post status labels.
	 */
	private function modify(): void
	{
		global $wp_post_statuses;

		$statuses = [
			'draft'       => [
				'label' => __('Unwritten', 'x3p0-a-boy-in-the-wild'),
				'count' => __('Unwritten <span class="count">(%s)</span>', 'x3p0-a-boy-in-the-wild'),
			],
			'publish'     => [
				'label' => __('In the Field', 'x3p0-a-boy-in-the-wild'),
				'count' => __('In the Field <span class="count">(%s)</span>', 'x3p0-a-boy-in-the-wild'),
			],
			'private'     => [
				'label' => __('Buried', 'x3p0-a-boy-in-the-wild'),
				'count' => __('Buried <span class="count">(%s)</span>', 'x3p0-a-boy-in-the-wild'),
			],
			'trash'       => [
				'label' => __('Lost', 'x3p0-a-boy-in-the-wild'),
				'count' => __('Lost <span class="count">(%s)</span>', 'x3p0-a-boy-in-the-wild'),
			],
			'future'      => [
				'label' => __('Forthcoming', 'x3p0-a-boy-in-the-wild'),
				'count' => __('Forthcoming <span class="count">(%s)</span>', 'x3p0-a-boy-in-the-wild'),
			],
			'pending'     => [
				'label' => __('Nearly There', 'x3p0-a-boy-in-the-wild'),
				'count' => __('Nearly There <span class="count">(%s)</span>', 'x3p0-a-boy-in-the-wild'),
			],
			'auto-draft'  => [
				'label' => __('Unstarted', 'x3p0-a-boy-in-the-wild'),
				'count' => __('Unstarted <span class="count">(%s)</span>', 'x3p0-a-boy-in-the-wild'),
			]
		];

		foreach ($statuses as $slug => $data) {
			if (! isset($wp_post_statuses[ $slug ])) {
				continue;
			}

			$status              = $wp_post_statuses[ $slug ];
			$status->label       = $data['label'];
			$status->label_count = _n_noop($data['count'], $data['count'], 'x3p0-a-boy-in-the-wild');
		}
	}

	/**
	 * Filters post states as they're displayed in the admin.
	 */
	private function displayPostStates(array $states, WP_Post $post): array
	{
		if ('post' !== $post->post_type) {
			return $states;
		}

		$map = [
			'draft'      => __('Unwritten',    'x3p0-a-boy-in-the-wild'),
			'pending'    => __('Nearly There', 'x3p0-a-boy-in-the-wild'),
			'future'     => __('Forthcoming',  'x3p0-a-boy-in-the-wild'),
			'private'    => __('Buried',       'x3p0-a-boy-in-the-wild'),
			'auto-draft' => __('Unstarted',    'x3p0-a-boy-in-the-wild'),
			'protected'  => __('Sealed',       'x3p0-a-boy-in-the-wild')
		];

		foreach ($states as $status => $label) {
			if (isset($map[ $status ])) {
				$states[ $status ] = $map[ $status ];
			}
		}

		return $states;
	}

}
