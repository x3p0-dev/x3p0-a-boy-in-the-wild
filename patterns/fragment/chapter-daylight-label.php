<?php
/**
 * Title: Chapter Daylight (Labeled)
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-daylight-label
 * Description: Displays a chapter's hours of daylight.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterField;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr(ChapterField::DaylightLabel->label()) ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterField::DaylightLabel->value) ?>"}
			}
		}
	}
} -->
<p><?= esc_html(ChapterField::DaylightLabel->label()) ?></p>
<!-- /wp:paragraph -->
