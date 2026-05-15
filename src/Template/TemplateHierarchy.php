<?php

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Template;

use WP_Post;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Registers templates with WordPress.
 */
final class TemplateHierarchy implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_filter('single_template_hierarchy', $this->singleTemplateHierarchy(...));
	}

	private function singleTemplateHierarchy(array $templates): array
	{
		if (! is_singular('post')) {
			return $templates;
		}

		$post = get_queried_object();

		if (! ($post instanceof WP_Post) || ! post_password_required($post)) {
			return $templates;
		}

		array_unshift($templates, 'single-post-sealed');

		return $templates;
	}
}
