<?php

/**
 * Title: Chapter Year
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-year
 * Description: Displays a chapter's year within the story with a label.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterField;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr(ChapterField::Year->label()) ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterField::Year->value) ?>"}
			}
		}
	}
} -->
<p><?= esc_html(ChapterField::Year->label()) ?></p>
<!-- /wp:paragraph -->
