<?php

/**
 * Title: Chapter Day
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-day
 * Description: Displays a chapter's day number.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterField;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr(ChapterField::Day->label()) ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterField::Day->value) ?>"}
			}
		}
	}
} -->
<p><?= esc_html(ChapterField::Day->label()) ?></p>
<!-- /wp:paragraph -->
