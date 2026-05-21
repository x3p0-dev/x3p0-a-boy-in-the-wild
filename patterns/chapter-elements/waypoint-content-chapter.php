<?php
/**
 * Title: Waypoint Content (Chapter)
 * Slug: x3p0-a-boy-in-the-wild/waypoint-content-chapter
 * Description: Header for chapters.
 * Categories: x3p0-chapter-elements
 * Inserter: yes
 */
?>

<!-- wp:group {
	"templateLock":"contentOnly",
	"metadata":{"name":"<?= esc_attr__('Waypoint Content (Chapter)', 'x3p0-a-boy-in-the-wild') ?>"},
	"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
	"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","alignItems":"center"}
} -->
<div class="wp-block-group">

	<!-- wp:group {
		"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
		"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}
	} -->
	<div class="wp-block-group">

		<!-- wp:site-title {"level":0} /-->

		<!-- wp:separator {"tagName":"div","className":"is-style-separator-inline"} -->
		<div class="wp-block-separator has-alpha-channel-opacity is-style-separator-inline"></div>
		<!-- /wp:separator -->

		<!-- wp:post-terms {"term":"category","prefix":"Era — "} /-->

	</div>
	<!-- /wp:group -->

	<!-- wp:buttons {
		"metadata":{"name":"<?= esc_attr__('Toggle Buttons', 'x3p0-a-boy-in-the-wild') ?>"},
		"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}
	} -->
	<div class="wp-block-buttons">

		<!-- wp:button {
			"tagName":"button",
			"metadata":{"name":"<?= esc_attr__('Audio Toggle', 'x3p0-a-boy-in-the-wild') ?>"},
			"className":"toggle-audio"
		} -->
		<div class="wp-block-button toggle-audio"><button type="button" class="wp-block-button__link wp-element-button"><?= esc_html__('Listen', 'x3p0-a-boy-in-the-wild') ?></button></div>
		<!-- /wp:button -->

		<!-- wp:button {
			"tagName":"button",
			"metadata":{"name":"<?= esc_attr__('Day/Night Toggle', 'x3p0-a-boy-in-the-wild') ?>"},
			"className":"toggle-color-scheme"
		} -->
		<div class="wp-block-button toggle-color-scheme"><button type="button" class="wp-block-button__link wp-element-button"><?= esc_html__('Day', 'x3p0-a-boy-in-the-wild') ?></button></div>
		<!-- /wp:button -->

	</div>
	<!-- /wp:buttons -->

</div>
<!-- /wp:group -->
