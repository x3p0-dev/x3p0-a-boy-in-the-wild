<?php
/**
 * Title: Chapter Time of Day
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-time
 * Description: Displays a chapter's time of day within the story.
 * Categories: x3p0-fragments
 * Inserter: yes
 */
?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr__('Time of Day', 'x3p0-a-boy-in-the-wild') ?>",
		"bindings":{
			"content":{
				"source":"x3p0/chapter",
				"args":{"field":"time"}
			}
		}
	}
} -->
<p><?= esc_html__('Time', 'x3p0-a-boy-in-the-wild') ?></p>
<!-- /wp:paragraph -->
