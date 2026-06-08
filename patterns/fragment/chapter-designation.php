<?php

/**
 * Title: Chapter Designation
 * Slug: x3p0-a-boy-in-the-wild/fragment-chapter-designation
 * Description: Displays a chapter's designation.
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
		"name":"<?= esc_attr(ChapterField::Designation->label()) ?>",
		"bindings":{
			"content":{
				"source":"<?= esc_attr(Chapter::NAME) ?>",
				"args":{"field":"<?= esc_attr(ChapterField::Designation->value) ?>"}
			}
		}
	}
} -->
<p><?= esc_html(ChapterField::Designation->label()) ?></p>
<!-- /wp:paragraph -->
