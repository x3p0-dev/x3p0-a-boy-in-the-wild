<?php

/**
 * Frontend Assets class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Frontend;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Asset\AssetResolver;

/**
 * Handles frontend asset loading and configuration.
 */
final class FrontendAssets implements Bootable
{
	/**
	 * Inline CSS limit.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	protected const INLINE_CSS_LIMIT = 50000;

	/**
	 * Screen style handle.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const SCREEN_HANDLE = 'x3p0-a-boy-in-the-wild-screen';

	/**
	 * Screen style path.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const SCREEN_PATH = 'public/css/screen.css';

	public function __construct(private readonly AssetResolver $assetResolver)
	{}

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('wp_enqueue_scripts', $this->enqueue(...));
		add_action('after_setup_theme', $this->addEditorStyles(...));
		add_filter('styles_inline_size_limit', $this->inlineStylesLimit(...));

		// Disable the emoji script.
		remove_action('wp_head', 'print_emoji_detection_script', 7);
	}

	/**
	 * Enqueue scripts/styles for the front end.
	 */
	private function enqueue(): void
	{
		$style = $this->assetResolver->asset(self::SCREEN_PATH);

		// Loads the primary stylesheet.
		wp_enqueue_style(
			self::SCREEN_HANDLE,
			$style->fileUrl(),
			$style->dependencies(),
			$style->version()
		);

		// Add path data so the stylesheet can potentially be inlined.
		wp_style_add_data(self::SCREEN_HANDLE, 'path', $style->filePath());
	}

	/**
	 * Adds the front-end stylesheet to the editor canvas so blocks render
	 * with the same styles (WYSIWYG) while editing.
	 */
	private function addEditorStyles(): void
	{
		$style = $this->assetResolver->asset(self::SCREEN_PATH);

		add_editor_style([$style->fileUrl()]);
	}

	/**
	 * Custom inline CSS size limit.
	 */
	private function inlineStylesLimit(int $total_inline_limit): int
	{
		return max(self::INLINE_CSS_LIMIT, $total_inline_limit);
	}
}
