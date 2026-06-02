<?php

/**
 * Title: Chapter Day (Number)
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-day-number
 * Description: Displays a chapter's day number.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Support\ChapterFields;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr__('Day (Number)', 'x3p0-a-boy-in-the-wild') ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterFields::DAY_NUMBER) ?>"}
			}
		}
	}
} -->
<p>0</p>
<!-- /wp:paragraph -->
