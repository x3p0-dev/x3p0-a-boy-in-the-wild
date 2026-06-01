<?php
/**
 * Title: Chapter Dateline
 * Slug: x3p0-a-boy-in-the-wild/chapter-dateline-season-time-excerpt
 * Description: Container for displaying the season, time, and excerpt.
 * Categories: x3p0-chapter-elements
 * Inserter: yes
 */
?>

<!-- wp:group {
	"metadata":{"name":"<?= esc_attr__('Chapter Dateline', 'x3p0-a-boy-in-the-wild') ?>"},
	"className":"is-style-container-meta",
	"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},
	"layout":{"type":"flex","flexWrap":"wrap"}
} -->
<div class="wp-block-group is-style-container-meta">

	<!-- wp:group {
		"style":{"spacing":{"blockGap":"var:preset|spacing|0"}},
		"layout":{"type":"flex","flexWrap":"nowrap"}
	} -->
	<div class="wp-block-group">

		<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/fragment-chapter-season"} /-->

		<!-- wp:paragraph -->
		<p>.</p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

	<!-- wp:group {
		"style":{"spacing":{"blockGap":"var:preset|spacing|0"}},
		"layout":{"type":"flex","flexWrap":"nowrap"}
	} -->
	<div class="wp-block-group">

		<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/fragment-chapter-time"} /-->

		<!-- wp:paragraph -->
		<p>.</p>
		<!-- /wp:paragraph -->

	</div>
	<!-- /wp:group -->

	<!-- wp:post-excerpt {"showMoreOnNewLine":false} /-->

</div>
<!-- /wp:group -->
