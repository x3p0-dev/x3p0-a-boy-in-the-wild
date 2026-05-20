<?php
/**
 * Title: The Chapters
 * Slug: x3p0-a-boy-in-the-wild/query-trail
 * Description: Trail path design for the Query Loop block.
 * Categories: x3p0-template-elements
 * Block Types: core/query
 * Inserter: yes
 */
?>

<!-- wp:query {"queryId":0,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[],"format":[]},"metadata":{"name":"The Chapters"}} -->
<div class="wp-block-query">

	<!-- wp:post-template {"className":"is-style-post-template-trail"} -->

	<!-- wp:group {"metadata":{"name":"Chapter"},"className":"chapter-entry","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
	<div class="wp-block-group chapter-entry">

		<!-- wp:icon {"icon":"core/map-marker","metadata":{"name":"The Pin"},"style":{"dimensions":{"width":"30px"},"layout":{"selfStretch":"fixed","flexSize":"30px"}}} /-->

		<!-- wp:group {"metadata":{"name":"Chapter Details"},"style":{"spacing":{"blockGap":"var:preset|spacing|0"}},"layout":{"type":"default"}} -->
		<div class="wp-block-group">

			<!-- wp:group {"metadata":{"name":"Chapter Header"},"className":"is-style-container-meta","layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-container-meta">

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/fragment-chapter-season"} /-->

			</div>
			<!-- /wp:group -->

			<!-- wp:post-title {"isLink":true} /-->

			<!-- wp:group {"metadata":{"name":"Chapter Footer"},"className":"is-style-container-meta","layout":{"type":"default"}} -->
			<div class="wp-block-group is-style-container-meta">
				<!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":25} /-->
			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

	<!-- /wp:post-template -->

</div>
<!-- /wp:query -->
