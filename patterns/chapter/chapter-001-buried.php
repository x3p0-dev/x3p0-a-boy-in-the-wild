<?php

/**
 * Title: Chapter 1 (Buried) — The Same Night
 * Slug: x3p0-a-boy-in-the-wild/chapter-001-buried
 * Description: Starter pattern for Chapter 1 (Buried)
 * Categories: x3p0-chapters-buried
 * Inserter: true
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

?>

<!-- wp:group {
	"metadata":{"name":"<?= esc_attr__('Entry', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full",
	"className":"is-style-section-state-buried",
	"style":{
		"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},
		"css":"--wp--custom--mark--separator: '\\2027';"
	},
	"layout":{"type":"default"}
} -->
<div class="wp-block-group alignfull is-style-section-state-buried has-custom-css" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">

	<!-- wp:group {
		"metadata":{"name":"<?= esc_attr__('Page', 'x3p0-a-boy-in-the-wild') ?>"},
		"align":"full",
		"layout":{"type":"constrained","contentSize":"55rem"}
	} -->
	<div class="wp-block-group alignfull">

		<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/waypoint-default"} /-->

		<!-- wp:group {
			"tagName":"main",
			"metadata":{"name":"<?= esc_attr__('Frame', 'x3p0-a-boy-in-the-wild') ?>"},
			"layout":{"type":"default"}
		} -->
		<main class="wp-block-group">

			<!-- wp:group {
				"tagName":"article",
				"metadata":{"name":"<?= esc_attr__('Chapter', 'x3p0-a-boy-in-the-wild') ?>"},
				"layout":{"type":"constrained","contentSize":"28rem","justifyContent":"left"}
			} -->
			<article class="wp-block-group">

				<!-- wp:group {
					"tagName":"header",
					"metadata":{"name":"<?= esc_attr__('Chapter Header', 'x3p0-a-boy-in-the-wild') ?>"},
					"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},
					"layout":{"type":"constrained"}
				} -->
				<header class="wp-block-group">

					<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/chapter-dateline"} /-->

					<!-- wp:post-title {
						"level":1,
						"placeholder":"<?= esc_attr__('The Same Night', 'x3p0-a-boy-in-the-wild') ?>"
					} /-->

				</header>
				<!-- /wp:group -->

				<!-- wp:group {
					"metadata":{"name":"<?= esc_attr__('Chapter Content', 'x3p0-a-boy-in-the-wild') ?>"},
					"className":"is-style-container-prose",
					"layout":{"type":"constrained"}
				} -->
				<div class="wp-block-group is-style-container-prose">

					<!-- wp:paragraph -->
					<p>I am writing this while the fire is still going because I don't know if I will write it later.</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph -->
					<p>I am <s>terrified</s>.</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph -->
					<p>I am not going to write that in the other one. This notebook is different. This one is just for me.</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph -->
					<p>There is something I am not writing yet. I know what it is. I am not ready to put it in words. Maybe tonight. Maybe not for a long time.</p>
					<!-- /wp:paragraph -->

					<!-- wp:spacer {"height":"var:preset|spacing|90"} -->
					<div style="height:var(--wp--preset--spacing--90)" aria-hidden="true" class="wp-block-spacer"></div>
					<!-- /wp:spacer -->

					<!-- wp:paragraph -->
					<p>The fire is still going. That is something. I made it. I am <s>proud</s> — it is adequate.</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"is-style-text-caption"} -->
					<p class="is-style-text-caption">In the other notebook I will say I was calm. I will believe it by the time I write it. That is how it works, I think.</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph -->
					<p>I am going to keep going. I don't know why. I am going to anyway.</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph -->
					<p>— not for the other notebook</p>
					<!-- /wp:paragraph -->

				</div>
				<!-- /wp:group -->

			</article>
			<!-- /wp:group -->

		</main>
		<!-- /wp:group -->

		<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/story-navigation-default"} /-->

	</div>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/canvas-scene-adrift"} /-->

</div>
<!-- /wp:group -->
