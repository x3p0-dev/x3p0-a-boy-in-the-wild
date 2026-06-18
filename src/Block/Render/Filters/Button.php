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
use X3P0\ABoyInTheWild\Block\ForBlock;
use X3P0\ABoyInTheWild\Block\Render\RenderFilter;

/**
 * Filters rendered output for the `core/button` block.
 */
#[ForBlock('core/button')]
final class Button implements RenderFilter
{
	private const AUDIO_CLASS = 'toggle-audio';

	private const COLOR_SCHEME_CLASS = 'toggle-color-scheme';

	/**
	 * Sets up the object state.
	 */
	public function __construct(private readonly AudioFacade $audio)
	{
	}

	/**
	 * Filters the Button block on render and runs any class methods based
	 * on various attributes that may be set.
	 */
	public function render(string $content, array $block, WP_Block $instance): string
	{
		$className = $block['attrs']['className'] ?? '';
		$contains = fn($subClass) => str_contains($className, $subClass);

		return match (true) {
			$contains(self::AUDIO_CLASS)        => $this->renderAudioToggle($content),
			$contains(self::COLOR_SCHEME_CLASS) => $this->renderColorSchemeToggle($content),
			default                             => $content
		};
	}

	/**
	 * Enables the audio interactivity if this is an audio toggle button.
	 */
	private function renderAudioToggle(string $content): string
	{
		$processor = new WP_HTML_Tag_Processor($content);

		if (! $this->nextButton($processor, self::AUDIO_CLASS)) {
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

	/**
	 * Enables the color scheme interactivity if this is a scheme toggle button.
	 *
	 * @todo Build out the color scheme system.
	 */
	private function renderColorSchemeToggle(string $content): string
	{
		$processor = new WP_HTML_Tag_Processor($content);

		if ($this->nextButton($processor, self::COLOR_SCHEME_CLASS)) {
			return '';
		}

		return $processor->get_updated_html();
	}

	/**
	 * Finds the next matching button block by class name and the next
	 * `<button>` element contained within.
	 */
	private function nextButton(WP_HTML_Tag_Processor $processor, string $className): bool
	{
		return $processor->next_tag(['class_name' => $className])
			&& $processor->next_tag('button');
	}
}
