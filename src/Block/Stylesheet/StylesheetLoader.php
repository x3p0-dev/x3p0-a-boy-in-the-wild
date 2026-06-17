<?php

/**
 * Stylesheet loader.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Stylesheet;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Support\CompiledAsset;

/**
 * Handles registering and enqueueing block stylesheets.
 *
 * This loader automatically discovers and enqueues block-specific stylesheets
 * using WordPress's block style API. Stylesheets are only loaded when their
 * associated blocks are actually used on a page, improving performance.
 */
final class StylesheetLoader implements Bootable
{
	/**
	 * Handle prefix used for registering block styles.
	 */
	private const HANDLE_PREFIX = 'x3p0-a-boy-in-the-wild-block';

	/**
	 * Sets up the stylesheet loader.
	 */
	public function __construct(private readonly StylesheetIterator $discovery)
	{}

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('init', $this->enqueue(...), 999999);
	}

	/**
	 * Enqueues block-specific styles for conditional loading.
	 *
	 * Iterates through discovered stylesheets and enqueues those that have
	 * accompanying asset files. This ensures styles are only loaded when
	 * their associated blocks are present on a page.
	 */
	private function enqueue(): void
	{
		foreach ($this->discovery as $stylesheet) {
			if ($stylesheet->hasAssetFile()) {
				$this->enqueueStylesheet($stylesheet);
			}
		}
	}

	/**
	 * Enqueues an individual block stylesheet with WordPress.
	 *
	 * Registers the stylesheet using WordPress's block style API, which
	 * handles conditional loading. The block name and style handle are
	 * derived from the file's parent directory (namespace) and filename
	 * (slug); dependencies and version come from its asset file.
	 */
	private function enqueueStylesheet(CompiledAsset $stylesheet): void
	{
		$namespace = $stylesheet->getPathInfo()->getBasename();
		$slug      = $stylesheet->getBasename('.css');

		wp_enqueue_block_style("{$namespace}/{$slug}", [
			'handle' => self::HANDLE_PREFIX . "-{$namespace}-{$slug}",
			'src'    => $stylesheet->fileUrl(),
			'path'   => $stylesheet->filePath(),
			'deps'   => $stylesheet->dependencies(),
			'ver'    => $stylesheet->version()
		]);
	}
}
