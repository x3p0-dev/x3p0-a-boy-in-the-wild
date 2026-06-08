<?php

/**
 * Title: First Chapter Button
 * Slug: x3p0-a-boy-in-the-wild/fragment-story-first-chapter-button
 * Description: Displays a button that links to the first chapter.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

use X3P0\ABoyInTheWild\Block\Binding\Sources\Story;

?>

<!-- wp:button {
	"metadata":{
		"bindings":{
			"url":{
				"source":"<?= esc_attr(Story::NAME) ?>",
				"args":{"field":"firstChapterUrl"}
			},
			"text":{
				"source":"<?= esc_attr(Story::NAME) ?>",
				"args":{"field":"firstChapterLabel"}
			}
		}
	},
	"className":"is-style-button-link"
} -->
<div class="wp-block-button is-style-button-link"><a class="wp-block-button__link wp-element-button" href="/"><?= esc_html__('Begin at the beginning →', 'x3p0-a-boy-in-the-wild') ?></a></div>
<!-- /wp:button -->
