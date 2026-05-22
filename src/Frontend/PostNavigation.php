<?php

/**
 * Post Navigation class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Frontend;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Customizes the previous/next post navigation links on the front end.
 */
final class PostNavigation implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_filter('next_post_link', $this->nextPostLink(...));
	}

	private function nextPostLink(string $output): string
	{
		if ('' === $output) {
			return __('To be continued&hellip;', 'x3p0-a-boy-in-the-wild');
		}

		return $output;
	}
}
