<?php
/**
 * Title: Chapter Year
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-year
 * Description: Displays a chapter's year within the story.
 * Categories: x3p0-fragments
 * Inserter: yes
 */
?>


<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr__('Year', 'x3p0-a-boy-in-the-wild') ?>",
		"bindings":{
			"content":{
				"source":"x3p0/chapter",
				"args":{"field":"year"}
			}
		}
	}
} -->
<p><?= esc_html__('Year', 'x3p0-a-boy-in-the-wild') ?></p>
<!-- /wp:paragraph -->
