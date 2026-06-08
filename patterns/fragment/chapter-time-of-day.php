<?php

/**
 * Title: Chapter Time of Day
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-time-of-day
 * Description: Displays a chapter's time of day within the story.
 * Categories: x3p0-fragments
 * Inserter: yes
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterField;

?>

<!-- wp:paragraph {
	"metadata":{
		"name":"<?= esc_attr(ChapterField::TimeOfDay->label()) ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterField::TimeOfDay->value) ?>"}
			}
		}
	}
} -->
<p><?= esc_html(ChapterField::TimeOfDay->label()) ?></p>
<!-- /wp:paragraph -->
