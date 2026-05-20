<?php

/**
 * Title: Chapter 1 — The Clearing
 * Slug: x3p0-a-boy-in-the-wild/chapter-001
 * Description: Starter pattern for Chapter 1. Late summer. Day 1. Age 12.
 * Categories: x3p0-chapters
 * Inserter: true
 */

declare(strict_types=1);

$background = get_theme_file_uri('public/media/images/system/season-late-summer.webp');
$sketch     =  get_theme_file_uri('public/media/images/chapter/001-clearing.webp');
?>

<!-- wp:group {
	"metadata":{"name":"<?= esc_attr__('Entry', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full",
	"className":"is-style-section-season-late-summer",
	"style":{
		"spacing":{
			"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70","right":"var:preset|spacing|70"}
		},
		"background":{
			"backgroundImage":{
				"url":"<?= esc_url($background) ?>",
				"id":419,
				"source":"file",
				"title":"late-summer-background"
			},
			"backgroundSize":"cover",
			"backgroundAttachment":"fixed",
			"backgroundPosition":"50% 0%"
		}
	},
	"layout":{"type":"constrained"}
} -->
<div class="wp-block-group alignfull is-style-section-season-late-summer" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/waypoint-default-full"} /-->

	<!-- wp:group {
		"tagName":"main",
		"metadata":{"name":"<?= esc_attr__('Frame', 'x3p0-a-boy-in-the-wild') ?>"},
		"align":"full",
		"layout":{"type":"constrained"}
	} -->
	<main class="wp-block-group alignfull">

		<!-- wp:group {
			"tagName":"article",
			"metadata":{"name":"<?= esc_attr__('Chapter', 'x3p0-a-boy-in-the-wild') ?>"},
			"align":"full",
			"layout":{"type":"constrained"}
		} -->
		<article class="wp-block-group alignfull">

			<!-- wp:group {
				"tagName":"header",
				"metadata":{"name":"<?= esc_attr__('Chapter Header', 'x3p0-a-boy-in-the-wild') ?>"},
				"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
				"layout":{"type":"constrained"}
			} -->
			<header class="wp-block-group">

				<!-- wp:group {
					"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},
					"layout":{"type":"constrained"}
				} -->
				<div class="wp-block-group">

					<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/chapter-dateline"} /-->

					<!-- wp:post-title {"level":1} /-->

				</div>
				<!-- /wp:group -->

				<!-- wp:separator {"opacity":"css","className":"is-style-separator-chapter-rule"} -->
				<hr class="wp-block-separator has-css-opacity is-style-separator-chapter-rule"/>
				<!-- /wp:separator -->

			</header>
			<!-- /wp:group -->

			<!-- wp:group {
				"metadata":{"name":"<?= esc_attr__('Chapter Content', 'x3p0-a-boy-in-the-wild') ?>"},
				"align":"full",
				"className":"is-style-container-prose",
				"layout":{"type":"constrained"}
			} -->
			<div class="wp-block-group alignfull is-style-container-prose">

				<!-- wp:paragraph {"dropCap":true"} -->
				<p class="has-drop-cap">I didn't run away. I just didn't come back. There is a difference and I know what it is even if no one else does. The clearing was already there when I found it. I only decided it was mine.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>I was calm. This is the part people would find hard to believe, if there were people. I was <s>terrified, barely functioning, crying for most of the first hour</s> calm. I made a fire. It was adequate.</p>
				<!-- /wp:paragraph -->

				<!-- wp:image {"id":243,"sizeSlug":"full","linkDestination":"none","align":"wide","className":"is-style-image-sketch"} -->
				<figure class="wp-block-image alignwide size-full is-style-image-sketch"><img src="<?= esc_url($sketch) ?>" alt="" class="wp-image-243"/><figcaption class="wp-element-caption">The Clearing. First Night.</figcaption></figure>
				<!-- /wp:image -->

				<!-- wp:paragraph -->
				<p>The wolves, or what I decided were wolves, kept their distance.</p>
				<!-- /wp:paragraph -->

				<!-- wp:spacer {"height":"3em"} -->
				<div style="height:3em" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:paragraph -->
				<p>I did not think about where I had come from. I thought about the fire. I thought about whether the wood I had chosen was the right wood. I thought about the dark at the edges of the light and whether it had opinions about me.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>The night lasted one night. In my telling it has lasted considerably longer. Both are true in the ways that matter. I have learned there are always two versions of every story I tell. This is the first story. It was the first night. I did not sleep.</p>
				<!-- /wp:paragraph -->

			</div>
			<!-- /wp:group -->

			<!-- wp:group {
				"tagName":"footer",
				"metadata":{"name":"<?= esc_attr__('Chapter Footer', 'x3p0-a-boy-in-the-wild') ?>"},
				"className":"is-style-container-meta",
				"style":{"spacing":{"blockGap":"var:preset|spacing|0"}},
				"layout":{"type":"flex","orientation":"vertical","justifyContent":"center"}
			} -->
			<footer class="wp-block-group is-style-container-meta">

				<!-- wp:separator {"className":"is-style-separator-endmark-field-note"} -->
				<hr class="wp-block-separator has-alpha-channel-opacity is-style-separator-endmark-field-note"/>
				<!-- /wp:separator -->

				<!-- wp:group {"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}} -->
				<div class="wp-block-group">

					<!-- wp:post-title {"level":6} /-->

					<!-- wp:separator {"tagName":"div","className":"is-style-separator-middle-dot"} -->
					<div class="wp-block-separator has-alpha-channel-opacity is-style-separator-middle-dot"></div>
					<!-- /wp:separator -->

					<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/fragment-chapter-season"} /-->

				</div>
				<!-- /wp:group -->

			</footer>
			<!-- /wp:group -->

		</article>
		<!-- /wp:group -->

	</main>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/story-navigation-default-full"} /-->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/canvas-bg-rising-embers"} /-->

</div>
<!-- /wp:group -->
