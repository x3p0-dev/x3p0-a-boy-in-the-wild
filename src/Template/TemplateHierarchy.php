<?php

/**
 * Template hierarchy service.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

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

	/**
	 * Adds a `single-post-sealed.html` template for password-protected
	 * posts. This allows them to be customized separately.
	 */
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
