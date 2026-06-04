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

use WP_HTML_Tag_Processor;
use WP_Post;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Rebrands the built-in post type as "Chapters" and customizes its admin list
 * table presentation.
 */
final class PostRowActions implements Bootable
{
	/**
	 * {@inheritDoc}
	 */
	public function boot(): void
	{
		add_filter('post_row_actions', $this->filter(...), 10, 2);
	}

	/**
	 * Rewrites the row action link labels (Edit/Trash/View) to use the
	 * chapter vocabulary.
	 */
	private function filter(array $actions, WP_Post $post): array
	{
		if ('post' !== $post->post_type) {
			return $actions;
		}

		$replacements = [
			'edit'  => __('Edit Chapter', 'x3p0-a-boy-in-the-wild'),
			'trash' => __('Mark as Lost', 'x3p0-a-boy-in-the-wild'),
			'view'  => __('Read Chapter', 'x3p0-a-boy-in-the-wild')
		];

		foreach ($replacements as $key => $label) {
			if (! isset($actions[$key])) {
				continue;
			}

			$processor = new WP_HTML_Tag_Processor($actions[$key]);

			if (
				$processor->next_tag('a') &&
				$processor->next_token() &&
				'#text' === $processor->get_token_name()
			) {
				$processor->set_modifiable_text($label);
			}

			$actions[$key] = $processor->get_updated_html();
		}

		return $actions;
	}
}
