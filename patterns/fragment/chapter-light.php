<?php
/**
 * Title: Chapter Light
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-light
 * Description: Displays a chapter's state of natural light.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterField;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr(ChapterField::Light->label()) ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterField::Light->value) ?>"}
			}
		}
	}
} -->
<p><?= esc_html(ChapterField::Light->label()) ?></p>
<!-- /wp:paragraph -->
