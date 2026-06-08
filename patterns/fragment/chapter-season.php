<?php

/**
 * Title: Chapter Season
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-season
 * Description: Displays a chapter's season.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterField;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr(ChapterField::Season->label()) ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterField::Season->value) ?>"}
			}
		}
	}
} -->
<p><?= esc_html(ChapterField::Season->label()) ?></p>
<!-- /wp:paragraph -->
