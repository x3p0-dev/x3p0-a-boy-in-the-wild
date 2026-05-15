<?php
/**
 * Title: Waypoint Content (Chapter)
 * Slug: x3p0-a-boy-in-the-wild/waypoint-content-chapter
 * Description: Header for chapters.
 * Categories: x3p0-chapter-elements
 * Inserter: yes
 */
?>

<!-- wp:group {"lock":{"move":false,"remove":false},"metadata":{"name":"Waypoint Content","categories":["featured"],"patternName":"x3p0-a-boy-in-the-wild/chapter-header"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","alignItems":"center"}} -->
<div class="wp-block-group">

	<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}} -->
	<div class="wp-block-group">

		<!-- wp:site-title {"level":0} /-->

		<!-- wp:paragraph {"metadata":{"name":"Separator"}} -->
		<p>·</p>
		<!-- /wp:paragraph -->

		<!-- wp:post-terms {"term":"category","prefix":"Era — "} /-->

	</div>
	<!-- /wp:group -->

	<!-- wp:buttons {"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}} -->
	<div class="wp-block-buttons">

		<!-- wp:button {"tagName":"button","metadata":{"bindings":{"url":{"source":"x3p0/site-data","args":{"field":"url"}}}},"className":"toggle-chapter-audio"} -->
		<div class="wp-block-button toggle-chapter-audio"><button type="button" class="wp-block-button__link wp-element-button">Listen</button></div>
		<!-- /wp:button -->

		<!-- wp:button {"tagName":"button","metadata":{"bindings":{"url":{"source":"x3p0/site-data","args":{"field":"url"}}}},"className":"toggle-color-scheme"} -->
		<div class="wp-block-button toggle-color-scheme"><button type="button" class="wp-block-button__link wp-element-button">Day</button></div>
		<!-- /wp:button -->

	</div>
	<!-- /wp:buttons -->

</div>
<!-- /wp:group -->
