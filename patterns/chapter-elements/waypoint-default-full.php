<?php

/**
 * Title: Waypoint (Full Width)
 * Slug: x3p0-a-boy-in-the-wild/waypoint-default-full
 * Description: Header wrapper.
 * Categories: x3p0-chapter-elements
 * Inserter: yes
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

?>

<!-- wp:group {
	"metadata":{"name":"<?= esc_attr__('Waypoint', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full",
	"className":"is-style-container-waypoint",
	"style":{"spacing":{"padding":{"right":"var:preset|spacing|70","left":"var:preset|spacing|70"}}},
	"layout":{"type":"default"}
} -->
<div class="wp-block-group alignfull is-style-container-waypoint" style="padding-right:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/waypoint-content-chapter"} /-->

</div>
<!-- /wp:group -->
