<?php

/**
 * Post Excerpt block render filter.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Render\Filters;

use WP_Block;
use WP_HTML_Tag_Processor;
use X3P0\ABoyInTheWild\Block\ForBlock;
use X3P0\ABoyInTheWild\Block\Render\RenderFilter;

/**
 * Filters rendered output for the `core/post-excerpt` block.
 *
 * When a post is password-protected, WordPress omits the excerpt from the
 * rendered block. This restores it when a manual excerpt has been set.
 */
#[ForBlock('core/post-excerpt')]
final class PostExcerpt implements RenderFilter
{
	/**
	 * @inheritDoc
	 */
	public function render(string $content, array $block, WP_Block $instance): string
	{
		$post_id = $instance->context['postId'] ?? null;

		if (! $post_id || ! post_password_required($post_id)) {
			return $content;
		}

		$post = get_post($post_id);

		if (! $post->post_excerpt) {
			return $content;
		}

		$tags = new WP_HTML_Tag_Processor($content);
		$tags->next_tag();

		$wrapper_attributes = $tags->get_attribute('class')
			? 'class="' . esc_attr($tags->get_attribute('class')) . '"'
			: '';

		if ($style = $tags->get_attribute('style')) {
			$wrapper_attributes .= ' style="' . esc_attr($style) . '"';
		}

		return sprintf(
			'<div %s><p class="wp-block-post-excerpt__excerpt">%s</p></div>',
			$wrapper_attributes,
			wp_kses_post($post->post_excerpt)
		);
	}
}
