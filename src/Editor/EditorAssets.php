<?php

/**
 * Editor assets class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Editor;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterField;
use X3P0\ABoyInTheWild\Support\CompiledAsset;

/**
 * Loads editor assets.
 */
final class EditorAssets implements Bootable
{
	/**
	 * Editor script handle.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const SCRIPT_HANDLE = 'x3p0-a-boy-in-the-wild-editor';

	/**
	 * Editor script path.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const SCRIPT_PATH = 'public/js/editor.js';

	/**
	 * Global JS object that server-side data is assigned to for editor
	 * scripts to read.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const SCRIPT_GLOBAL = 'x3p0ABoyInTheWild';

	/**
	 * Editor style handle.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const STYLE_HANDLE = 'x3p0-a-boy-in-the-wild-editor';

	/**
	 * Editor style path.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const STYLE_PATH = 'public/css/editor.css';

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('enqueue_block_editor_assets', $this->enqueue(...));
	}

	/**
	 * Loads editor assets.
	 */
	private function enqueue(): void
	{
		$script = new CompiledAsset(self::SCRIPT_PATH);
		$style  = new CompiledAsset(self::STYLE_PATH);

		wp_enqueue_script(
			self::SCRIPT_HANDLE,
			$script->fileUrl(),
			$script->dependencies(),
			$script->version(),
			true
		);

		// Set translations for editor scripts.
		// @link https://developer.wordpress.org/reference/functions/wp_set_script_translations/
		wp_set_script_translations(self::SCRIPT_HANDLE, 'x3p0-a-boy-in-the-wild');

		// Hand the chapter field list to the `x3p0/chapter` binding
		// source so its editor field picker is generated from the
		// ChapterField enum.
		wp_add_inline_script(
			self::SCRIPT_HANDLE,
			sprintf(
				'window.%1$s = Object.assign(window.%1$s || {}, %2$s);',
				self::SCRIPT_GLOBAL,
				wp_json_encode(['chapterFields' => ChapterField::options()])
			),
			'before'
		);

		wp_enqueue_style(
			self::STYLE_HANDLE,
			$style->fileUrl(),
			$style->dependencies(),
			$style->version()
		);
	}
}
