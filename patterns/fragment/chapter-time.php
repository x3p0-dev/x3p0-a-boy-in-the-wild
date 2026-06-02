<?php

/**
 * Title: Chapter Time of Day
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-time
 * Description: Displays a chapter's time of day within the story.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Support\ChapterFields;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr__('Time of Day', 'x3p0-a-boy-in-the-wild') ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterFields::TIME) ?>"}
			}
		}
	}
} -->
<p><?= esc_html__('Time', 'x3p0-a-boy-in-the-wild') ?></p>
<!-- /wp:paragraph -->
