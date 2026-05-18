<?php
/**
 * Title: Query Trail
 * Slug: x3p0-a-boy-in-the-wild/query-trail
 * Description: Trail path design for the Query Loop block.
 * Categories: x3p0-chapter-elements
 * Block Types: core/query
 * Inserter: yes
 */
?>

<!-- wp:query {"queryId":0,"query":{"perPage":10,"pages":0,"offset":0,"postType":"post","order":"asc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":true,"taxQuery":null,"parents":[],"format":[]},"metadata":{"name":"The Chapters"}} -->
<div class="wp-block-query">

	<!-- wp:post-template {"className":"is-style-post-template-trail-path"} -->

	<!-- wp:group {"metadata":{"name":"Chapter Entry"},"className":"chapter-entry","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}} -->
	<div class="wp-block-group chapter-entry"><!-- wp:icon {"icon":"core/map-marker","metadata":{"name":"The Pin"},"style":{"dimensions":{"width":"30px"},"layout":{"selfStretch":"fixed","flexSize":"30px"}}} /-->

		<!-- wp:group {"metadata":{"name":"Chapter Details"},"style":{"spacing":{"blockGap":"var:preset|spacing|0"}},"layout":{"type":"default"}} -->
		<div class="wp-block-group"><!-- wp:paragraph {"metadata":{"name":"Season","bindings":{"content":{"source":"x3p0/post-data","args":{"field":"season"}}}},"className":"is-style-chapter-meta"} -->
			<p class="is-style-chapter-meta">Season</p>
			<!-- /wp:paragraph -->

			<!-- wp:post-title {"isLink":true,"className":"is-style-trail-chapter-title"} /-->

			<!-- wp:post-excerpt {"showMoreOnNewLine":false,"excerptLength":25,"className":"is-style-chapter-meta"} /--></div>
		<!-- /wp:group -->

	</div>
	<!-- /wp:group -->

	<!-- /wp:post-template -->

</div>
<!-- /wp:query -->
