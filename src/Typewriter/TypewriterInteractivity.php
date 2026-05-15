<?php

/**
 * Typewriter interactivity handler.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Typewriter;

use WP_HTML_Tag_Processor;

/**
 * Manages Interactivity API integration for the typewriter effect.
 */
final class TypewriterInteractivity
{
	/**
	 * Interactivity API store name. Must match the store defined in the
	 * script module.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const STORE = 'x3p0-a-boy-in-the-wild/typewriter';

	/**
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	public const CALLBACK_INIT = 'callbacks.init';

	public function __construct(private readonly TypewriterAssets $assets)
	{}

	/**
	 * Enables the typewriter effect by enqueueing assets.
	 */
	public function enable(): void
	{
		$this->assets->enqueue();
	}

	/**
	 * Adds the Interactivity API directives to the element.
	 */
	public function addDirectives(WP_HTML_Tag_Processor $processor): WP_HTML_Tag_Processor
	{
		$processor->set_attribute('data-wp-interactive', self::STORE);
		$processor->set_attribute('data-wp-init',        self::CALLBACK_INIT);

		return $processor;
	}
}
