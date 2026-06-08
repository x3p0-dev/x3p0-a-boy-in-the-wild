<?php

/**
 * Title: Story Navigation (Full Width)
 * Slug: x3p0-a-boy-in-the-wild/story-navigation-default-full
 * Description: Wrapper for story navigation.
 * Categories: x3p0-chapter-elements
 * Inserter: yes
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

?>

<!-- wp:group {
	"tagName":"footer",
	"metadata":{"name":"<?= esc_attr__('Story Navigation', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full",
	"style":{"spacing":{"padding":{"right":"var:preset|spacing|70","left":"var:preset|spacing|70"}}},
	"layout":{"type":"default"}
} -->
<footer class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

	<!-- wp:separator -->
	<hr class="wp-block-separator has-alpha-channel-opacity"/>
	<!-- /wp:separator -->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/story-navigation-content"} /-->

</footer>
<!-- /wp:group -->
