<?php

/**
 * Group block render filter.
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
use X3P0\ABoyInTheWild\Block\Render\RenderFilter;
use X3P0\ABoyInTheWild\Typewriter\TypewriterConfig;
use X3P0\ABoyInTheWild\Typewriter\TypewriterInteractivity;

/**
 * Filters rendered output for the `core/group` block.
 */
final class Group extends RenderFilter
{
	protected const BLOCK_TYPE = 'core/group';

	public function __construct(private readonly TypewriterInteractivity $typewriter)
	{}

	/**
	 * @inheritDoc
	 */
	protected function render(string $content, array $block, WP_Block $instance): string
	{
		$classes = $block['attrs']['className'] ?? '';

		if (str_contains($classes, TypewriterConfig::CSS_CLASS)) {
			return $this->renderTypewriter($content);
		}

		return $content;
	}

	/**
	 * Adds Interactivity API directives to enable the typewriter effect.
	 */
	private function renderTypewriter(string $content): string
	{
		$processor = new WP_HTML_Tag_Processor($content);

		if (! $processor->next_tag()) {
			return $content;
		}

		$this->typewriter->enable();
		$this->typewriter->addDirectives($processor);

		return $processor->get_updated_html();
	}
}
