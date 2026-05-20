<?php
/**
 * Title: Story Navigation Content
 * Slug: x3p0-a-boy-in-the-wild/story-navigation-content
 * Description: Stores the navigation links for moving between chapters.
 * Categories: x3p0-chapter-elements
 * Inserter: yes
 */
?>

<!-- wp:group {
	"templateLock":"contentOnly",
	"metadata":{"name":"<?= esc_attr__('Story Navigation Content', 'x3p0-a-boy-in-the-wild') ?>"},
	"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"center"}
} -->
<div class="wp-block-group">

	<!-- wp:post-navigation-link {
		"type":"previous",
		"label":"<?= esc_html__('← Previous', 'x3p0-a-boy-in-the-wild') ?>",
		"showTitle":true,
		"metadata":{"name":"<?= esc_attr__('Previous Chapter', 'x3p0-a-boy-in-the-wild') ?>"},
		"className":"is-style-post-navigation-link-chapter",
		"style":{"layout":{"selfStretch":"fill","flexSize":null}}
	} /-->

	<!-- wp:post-navigation-link {
		"label":"<?= esc_html__('Next →', 'x3p0-a-boy-in-the-wild') ?>",
		"showTitle":true,
		"metadata":{"name":"<?= esc_attr__('Next Chapter', 'x3p0-a-boy-in-the-wild') ?>"},
		"className":"is-style-post-navigation-link-chapter",
		"style":{"typography":{"textAlign":"right"},
		"layout":{"selfStretch":"fill","flexSize":null}}
	} /-->

</div>
<!-- /wp:group -->
