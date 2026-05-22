<?php

/**
 * Pattern category registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Pattern;

use WP_Block_Pattern_Categories_Registry;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Registers block pattern categories.
 */
final class PatternCategoryRegistrar implements Bootable
{
	/**
	 * Sets up the object state.
	 */
	public function __construct()
	{}

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('init', $this->register(...), -999999);
	}

	/**
	 * Register block pattern categories. Note that this theme registers
	 * patterns by adding them as individual pattern files in the `/patterns`
	 * folder.
	 */
	private function register(): void
	{
		register_block_pattern_category('x3p0-chapters', [
			'label'       => __('Story Chapters', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Starter patterns that contain a new chapter of the story with unique designs.' ,'x3p0-a-boy-in-the-wild')
		]);

		register_block_pattern_category('x3p0-chapters-buried', [
			'label'       => __('Story Chapters (Buried)', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Starter patterns that contain a new buried chapter of the story with unique designs.' ,'x3p0-a-boy-in-the-wild')
		]);

		register_block_pattern_category('x3p0-chapter-elements', [
			'label'       => __('Chapter Elements', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Patterns used for various chapter elements.' ,'x3p0-a-boy-in-the-wild')
		]);

		register_block_pattern_category('x3p0-background-animations', [
			'label'       => __('Background Animations', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Animated backgrounds meant for use for the page.' ,'x3p0-a-boy-in-the-wild')
		]);

		register_block_pattern_category('x3p0-template-elements', [
			'label'       => __('Template Elements', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Patterns used for various elements in templates.' ,'x3p0-a-boy-in-the-wild')
		]);

		register_block_pattern_category('x3p0-fragments', [
			'label'       => __('Fragments', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Small and reusable elements.' ,'x3p0-a-boy-in-the-wild')
		]);
	}
}
