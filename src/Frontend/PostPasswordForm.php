<?php

/**
 * Password Form class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Frontend;

use WP_Post;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Renders a custom version of the post password form.
 */
final class PostPasswordForm implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_filter('the_password_form', $this->thePasswordForm(...), 10, 2);
	}

	/**
	 * Filter the password form with a custom one for the theme.
	 */
	private function thePasswordForm(string $form, WP_Post $post): string
	{
		return sprintf(
			'<!-- wp:html -->
				<form action="%1$s" method="post">
					<label class="chapter-protected__label" for="pwbox-%2$d">%3$s</label>
					<div class="chapter-protected__row">
						<input placeholder="%4$s" name="post_password" id="pwbox-%2$d" type="password" size="20" />
						<input type="submit" name="Submit" value="%5$s" />
					</div>
				</form>
			<!-- /wp:html -->',
			esc_url(site_url('wp-login.php?action=postpass', 'login_post')),
			absint($post->ID),
			esc_html__('The key', 'x3p0-a-boy-in-the-wild'),
			esc_attr__('Enter the key', 'x3p0-a-boy-in-the-wild'),
			esc_attr__('Open', 'x3p0-a-boy-in-the-wild')
		);
	}
}
