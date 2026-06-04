<?php

/**
 * Title: Chapter Day
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-day-label
 * Description: Displays a chapter's day with a label.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterField;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr__('Day', 'x3p0-a-boy-in-the-wild') ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterField::DayLabel->value) ?>"}
			}
		}
	}
} -->
<p><?= esc_html__('Day', 'x3p0-a-boy-in-the-wild') ?></p>
<!-- /wp:paragraph -->
