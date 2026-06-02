<?php

/**
 * Title: Chapter Year
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-year
 * Description: Displays a chapter's year within the story.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Support\ChapterFields;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr__('Year', 'x3p0-a-boy-in-the-wild') ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterFields::YEAR) ?>"}
			}
		}
	}
} -->
<p><?= esc_html__('Year', 'x3p0-a-boy-in-the-wild') ?></p>
<!-- /wp:paragraph -->
