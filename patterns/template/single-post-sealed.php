<?php

/**
 * Title: Single Post (Sealed) Template
 * Slug: x3p0-a-boy-in-the-wild/template-single-post-sealed
 * Inserter: no
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

?>

<!-- wp:group {
	"metadata":{"name":"<?= esc_attr__('Entry', 'x3p0-a-boy-in-the-wild'); ?>"},
	"align":"full",
	"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70","right":"var:preset|spacing|70"}}},
	"layout":{"type":"constrained"}
} -->
<div class="wp-block-group alignfull" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/waypoint-default-full"} /-->

	<!-- wp:group {
		"tagName":"main",
		"metadata":{"name":"<?= esc_attr__('Entry', 'x3p0-a-boy-in-the-wild'); ?>"},
		"align":"full",
		"layout":{"type":"constrained"}
	} -->
	<main class="wp-block-group alignfull">

		<!-- wp:group {
			"tagName":"article",
			"metadata":{"name":"<?= esc_attr__('Chapter', 'x3p0-a-boy-in-the-wild'); ?>"},
			"align":"full",
			"layout":{"type":"constrained"}
		} -->
		<article class="wp-block-group alignfull">

			<!-- wp:icon {"icon":"x3p0/sealed-key","align":"center","className":"is-style-icon-pulse-fade","style":{"dimensions":{"width":"64px"},"elements":{"link":{"color":{"text":"var:preset|color|ink-muted"}}}},"textColor":"ink-muted"} /-->

			<!-- wp:group {
				"tagName":"header",
				"metadata":{"name":"<?= esc_attr__('Chapter Header', 'x3p0-a-boy-in-the-wild'); ?>"},
				"style":{"spacing":{"blockGap":"var:preset|spacing|40"},"typography":{"textAlign":"center"}},
				"layout":{"type":"constrained"}
			} -->
			<header class="wp-block-group has-text-align-center">

				<!-- wp:group {
					"className":"is-style-container-meta",
					"layout":{"type":"constrained"}
				} -->
				<div class="wp-block-group is-style-container-meta">
					<!-- wp:post-excerpt {"showMoreOnNewLine":false} /-->
				</div>
				<!-- /wp:group -->

				<!-- wp:post-title {"level":1} /-->

			</header>
			<!-- /wp:group -->

			<!-- wp:group {
				"metadata":{"name":"<?= esc_attr__('Chapter Content', 'x3p0-a-boy-in-the-wild'); ?>"},
				"align":"full",
				"layout":{"type":"constrained","contentSize":"20rem"}
			} -->
			<div class="wp-block-group alignfull">

				<!-- wp:separator {"opacity":"css"} -->
				<hr class="wp-block-separator has-css-opacity"/>
				<!-- /wp:separator -->

				<!-- wp:group {
					"className":"chapter-protected",
					"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}
				} -->
				<div class="wp-block-group chapter-protected">

					<!-- wp:paragraph {"className":"is-style-text-aside","style":{"typography":{"textAlign":"center"}}} -->
					<p class="has-text-align-center is-style-text-aside">This chapter is sealed. If you have the key, you know what to do with it.</p>
					<!-- /wp:paragraph -->

					<!-- wp:post-content {"lock":{"move":false,"remove":true},"layout":{"type":"constrained"}} /-->

					<!-- wp:paragraph {"className":"is-style-text-caption","style":{"typography":{"textAlign":"center"}}} -->
					<p class="has-text-align-center is-style-text-caption">The key is somewhere in the chapters. If you don't have it yet, keep reading.</p>
					<!-- /wp:paragraph -->

				</div>
				<!-- /wp:group -->

			</div>
			<!-- /wp:group -->

			<!-- wp:spacer -->
			<div style="height:100px" aria-hidden="true" class="wp-block-spacer"></div>
			<!-- /wp:spacer -->

		</article>
		<!-- /wp:group -->

	</main>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/story-navigation-default-full"} /-->

</div>
<!-- /wp:group -->
