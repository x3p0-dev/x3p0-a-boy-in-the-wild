<?php

/**
 * Button block render filter.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Render\Filters;

use WP_Block;
use WP_HTML_Tag_Processor;
use X3P0\ABoyInTheWild\Audio\AudioInteractivity;
use X3P0\ABoyInTheWild\Audio\AudioFacade;
use X3P0\ABoyInTheWild\Block\Render\RenderFilter;

/**
 * Filters rendered output for the `core/button` block.
 */
final class Button extends RenderFilter
{
	protected const BLOCK_TYPE = 'core/button';

	private const AUDIO_CLASS = 'toggle-audio';

	private const COLOR_SCHEME_CLASS = 'toggle-color-scheme';

	/**
	 * Sets up the object state.
	 */
	public function __construct(private readonly AudioFacade $audio)
	{}

	/**
	 * Filters the Button block on render and runs any class methods based
	 * on various attributes that may be set.
	 */
	protected function render(string $content, array $block, WP_Block $instance): string
	{
		if (
			isset($block['attrs']['className'])
			&& str_contains($block['attrs']['className'], self::AUDIO_CLASS)
		) {
			return $this->renderAudioToggle($content);
		}

		// @todo - The color scheme is not active in the theme yet.
		if (
			isset($block['attrs']['className'])
			&& str_contains($block['attrs']['className'], self::COLOR_SCHEME_CLASS)
		) {
			return '';
		}

		return $content;
	}

	/**
	 * Enables the audio interactivity if this is an audio toggle button.
	 */
	private function renderAudioToggle(string $content): string
	{
		$processor = new WP_HTML_Tag_Processor($content);

		if (
			! $processor->next_tag(['class_name' => self::AUDIO_CLASS])
			|| ! $processor->next_tag('button')
		) {
			return $processor->get_updated_html();
		}

		if (! $this->audio->resolver()->hasAudio()) {
			return '';
		}

		// Enable interactivity. This handles adding the directives,
		// setting the interactive state, and enqueueing the script.
		$this->audio->interactivity()->addDirectives($processor);
		$this->audio->interactivity()->enable();

		return $processor->get_updated_html();
	}
}
