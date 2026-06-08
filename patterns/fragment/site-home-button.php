<?php

/**
 * Title: Home Button
 * Slug: x3p0-a-boy-in-the-wild/fragment-site-home-button
 * Description: Displays a button that links to the homepage.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

use X3P0\ABoyInTheWild\Block\Binding\Sources\Site;

?>

<!-- wp:button {
	"metadata":{
		"bindings":{
			"url":{
				"source":"<?= esc_attr(Site::NAME) ?>",
				"args":{"field":"url"}
			}
		}
	},
	"className":"is-style-button-link"
} -->
<div class="wp-block-button is-style-button-link"><a class="wp-block-button__link wp-element-button" href="/"><?= esc_html__('← All Chapters', 'x3p0-a-boy-in-the-wild') ?></a></div>
<!-- /wp:button -->
