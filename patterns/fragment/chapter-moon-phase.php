<?php
/**
 * Title: Chapter Moon Phase
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-moon-phase
 * Description: Displays a chapter's moon phase.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterField;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr__('Moon Phase', 'x3p0-a-boy-in-the-wild') ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterField::MoonPhase->value) ?>"}
			}
		}
	}
} -->
<p><?= esc_html__('Moon', 'x3p0-a-boy-in-the-wild') ?></p>
<!-- /wp:paragraph -->
