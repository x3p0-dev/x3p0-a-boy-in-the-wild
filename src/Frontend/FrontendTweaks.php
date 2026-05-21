<?php

/**
 * Frontend Tweaks class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Frontend;

use WP;
use WP_Block_Template;
use WP_Post;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Handles WordPress query variable fixes and modifications.
 */
final class FrontendTweaks implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('parse_request', $this->parseRequest(...));
		add_filter('wp_required_field_message', $this->requiredFieldMessage(...));
		add_filter('the_password_form', $this->thePasswordForm(...), 10, 2);
		add_filter('protected_title_format', $this->protectedTitleFormat(...), 10, 2);
		add_filter('private_title_format', $this->privateTitleFormat(...), 10, 2);
		add_filter('next_post_link', $this->nextPostLink(...));
	}

	/**
	 * When using a paged Query Loop block, WordPress doesn't set the `paged`
	 * query var. So functions like `is_paged()` do not work correctly for
	 * these types of paginated views, and the `paged` body class is missing.
	 * This action checks for that case and sets the `paged` query var.
	 */
	private function parseRequest(WP $wp): void
	{
		$page = $this->getQueryBlockPage();

		if (1 < $page) {
			$wp->query_vars['paged'] = $page;
		}
	}

	/**
	 * Gets the current page number when there's a paginated Query Loop
	 * block. WordPress doesn't have a conditional function for this.
	 */
	private function getQueryBlockPage(): int
	{
		// Get the URL query for the requested URI.
		$query = wp_parse_url(esc_url_raw(add_query_arg([])), PHP_URL_QUERY);

		// Bail early if this is not a paginated page.
		if (
			! $query
			|| ! str_contains($query, 'query-')
			|| ! str_contains($query, 'page=')
		) {
			return 0;
		}

		// Checks for `?query-page={x}` and `query-{x}-page={y}`.
		preg_match('#query-(\d+-)?page=(\d+)#', $query, $matches);

		return isset($matches[2]) ? absint($matches[2]) : 0;
	}

	/**
	 * Replaces the space before the required field indicator with a
	 * non-breaking space. This ensures that the indicator doesn't end up on
	 * a line by itself in the comment form. 😢
	 */
	private function requiredFieldMessage(string $message): string
	{
		$indicator = wp_required_field_indicator();

		return str_replace(" {$indicator}", "&nbsp;{$indicator}", $message);
	}

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

	private function protectedTitleFormat(string $prepend, WP_Post $post): string
	{
		return is_single($post->ID)
			? '%s'
			: '<span>%s</span> <span class="wp-block-post-title__status">&ndash; ' . __('Sealed', 'x3p0-a-boy-in-the-wild') . '</span>';
	}

	private function privateTitleFormat(string $prepend, WP_Post $post): string
	{
		return is_single($post->ID)
			? '%s'
			: '<span>%s</span> <span class="wp-block-post-title__status">&ndash; ' . get_post_status_object($post->post_status)->label . '</span>';
	}

	private function nextPostLink(string $output): string
	{
		if ('' === $output) {
			return __('To be continued&hellip;', 'x3p0-a-boy-in-the-wild');
		}

		return $output;
	}
}
