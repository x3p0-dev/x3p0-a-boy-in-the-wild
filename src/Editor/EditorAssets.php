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
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('after_setup_theme', $this->addEditorStyles(...));
		add_action('enqueue_block_editor_assets', $this->enqueue(...));
	}

	/**
	 * Add editor stylesheets.
	 */
	private function addEditorStyles(): void
	{
		add_editor_style([
			get_parent_theme_file_uri('public/css/screen.css')
		]);
	}

	/**
	 * Loads editor assets.
	 */
	private function enqueue(): void
	{
		$script = new CompiledAsset('public/js/editor.js');
		$style  = new CompiledAsset('public/css/editor.css');

		wp_enqueue_script(
			'x3p0-a-boy-in-the-wild-editor',
			$script->fileUrl(),
			$script->dependencies(),
			$script->version(),
			true
		);

		// Set translations for editor scripts.
		// @link https://developer.wordpress.org/reference/functions/wp_set_script_translations/
		wp_set_script_translations('x3p0-a-boy-in-the-wild-editor', 'x3p0-a-boy-in-the-wild');

		// Hand the chapter field list to the `x3p0/chapter` binding
		// source so its editor field picker is generated from the
		// ChapterField enum.
		wp_add_inline_script(
			'x3p0-a-boy-in-the-wild-editor',
			sprintf(
				'window.x3p0ABoyInTheWild = Object.assign(window.x3p0aBoyInTheWild || {}, %s);',
				wp_json_encode(['chapterFields' => ChapterField::options()])
			),
			'before'
		);

		wp_enqueue_style(
			'x3p0-a-boy-in-the-wild-editor',
			$style->fileUrl(),
			$style->dependencies(),
			$style->version()
		);
	}
}
