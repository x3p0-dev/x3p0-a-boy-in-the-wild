<?php

/**
 * Title: Chapter 4 — The Thing I Buried
 * Slug: x3p0-a-boy-in-the-wild/chapter-004
 * Description: Starter pattern for Chapter 4.
 * Categories: x3p0-chapters
 * Inserter: true
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;
?>

<!-- wp:group {
	"metadata":{"name":"<?= esc_attr__('Entry', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full",
	"className":"is-style-section-arc-spine",
	"style":{
		"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70","right":"var:preset|spacing|70"}}
	},
	"layout":{"type":"constrained"}
} -->
<div class="wp-block-group alignfull is-style-section-arc-spine" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

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
			"style":{"spacing":{"padding":{"right":"var:preset|spacing|0","left":"var:preset|spacing|0"}}},
			"layout":{"type":"constrained"}
		} -->
		<article class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">

			<!-- wp:group {
				"tagName":"header",
				"metadata":{"name":"<?= esc_attr__('Chapter Header', 'x3p0-a-boy-in-the-wild') ?>"},
				"align":"full",
				"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
				"layout":{"type":"constrained"}
			} -->
			<header class="wp-block-group alignfull">

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/chapter-dateline-season-day-excerpt"} /-->

				<!-- wp:post-title {
					"level":1,
					"metadata":{"name":"<?= esc_attr__('Chapter Title', 'x3p0-a-boy-in-the-wild') ?>"}
				} /-->

				<!-- wp:separator {
					"opacity":"css",
					"metadata":{"name":"<?= esc_attr__('Chapter Rule', 'x3p0-a-boy-in-the-wild') ?>"},
					"className":"is-style-separator-chapter-draw"
				} -->
				<hr class="wp-block-separator has-css-opacity is-style-separator-draw"/>
				<!-- /wp:separator -->

			</header>
			<!-- /wp:group -->

			<!-- wp:group {
				"metadata":{"name":"<?= esc_attr__('Chapter Content', 'x3p0-a-boy-in-the-wild') ?>"},
				"align":"full",
				"className":"is-style-prose",
				"layout":{"type":"constrained"}
			} -->
			<div class="wp-block-group alignfull is-style-prose">

				<!-- wp:paragraph {"dropCap":true} -->
				<p class="has-drop-cap">I buried it on the third day. I have not written about this until now because I did not want to write about it until now. That is all the explanation I am going to give for the delay.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>It is wrapped in the shirt I was wearing when I arrived here. I could not carry it and I could not leave it and I could not look at it anymore so I put it in the ground. The ground accepted it without comment. This is one of the things I have come to appreciate about the ground.</p>
				<!-- /wp:paragraph -->

				<!-- wp:spacer {"height":"var:preset|spacing|70"} -->
				<div style="height:var(--wp--preset--spacing--70)" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:group {
					"metadata":{"name":"<?= esc_attr__('The Buried Thing', 'x3p0-a-boy-in-the-wild') ?>"},
					"className":"is-style-container-elevated",
					"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70","right":"var:preset|spacing|70"}}},
					"layout":{"type":"constrained"}
				} -->
				<div class="wp-block-group is-style-container-elevated" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

					<!-- wp:heading {"className":"is-style-text-caption"} -->
					<h2 class="wp-block-heading is-style-text-caption">The Place Where I Buried Something</h2>
					<!-- /wp:heading -->

					<!-- wp:paragraph -->
					<p>I buried it on the third day when I was certain no one was watching. It is wrapped in <span class="redacted">the shirt I was wearing when I arrived here. The location</span> on this map is deliberately wrong. I will know where it actually is.</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"is-style-text-caption"} -->
					<p class="is-style-text-caption">I know what it is. I'm not ready.</p>
					<!-- /wp:paragraph -->

				</div>
				<!-- /wp:group -->

				<!-- wp:paragraph -->
				<p>I will not describe what it is. <s>I know what it is and I am not ready to write it here and I may never be ready to write it here and that is my decision to make.</s></p>
				<!-- /wp:paragraph -->

				<!-- wp:spacer {"height":"var:preset|spacing|70"} -->
				<div style="height:var(--wp--preset--spacing--70)" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:paragraph {
					"style":{
						"typography":{"fontStyle":"italic","fontSize":"var(--wp--preset--font-size--sm)","textAlign":"center"},
						"color":{"text":"var(--wp--custom--color--foreground--muted)"}
					}
				} -->
				<p class="has-text-align-center has-text-color" style="color:var(--wp--custom--color--foreground--muted);font-size:var(--wp--preset--font-size--sm);font-style:italic">The frost came that night. The ground sealed over it.<br>I did not go back.</p>
				<!-- /wp:paragraph -->

				<!-- wp:group {
					"metadata":{"name":"<?= esc_attr__('Spine Marker', 'x3p0-a-boy-in-the-wild') ?>"},
					"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}}},
					"layout":{"type":"flex","orientation":"vertical","justifyContent":"center","alignItems":"center"}
				} -->
				<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">

					<!-- wp:separator {"className":"is-style-separator-spine-marker"} -->
					<hr class="wp-block-separator has-alpha-channel-opacity is-style-separator-spine-marker"/>
					<!-- /wp:separator -->

					<!-- wp:paragraph {"className":"is-style-text-caption","style":{"typography":{"textAlign":"center"}}} -->
					<p class="has-text-align-center is-style-text-caption">this chapter returns</p>
					<!-- /wp:paragraph -->

				</div>
				<!-- /wp:group -->

			</div>
			<!-- /wp:group -->

			<!-- wp:group {
				"tagName":"footer",
				"metadata":{"name":"<?= esc_attr__('Chapter Footer', 'x3p0-a-boy-in-the-wild') ?>"},
				"className":"is-style-container-meta",
				"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},
				"layout":{"type":"constrained"}
			} -->
			<footer class="wp-block-group is-style-container-meta">

				<!-- wp:group {
					"style":{"spacing":{"blockGap":"var:preset|spacing|30"}},
					"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"center"}
				} -->
				<div class="wp-block-group">

					<!-- wp:post-title {"level":6} /-->

					<!-- wp:separator {"className":"is-style-separator-inline"} -->
					<hr class="wp-block-separator has-alpha-channel-opacity is-style-separator-inline"/>
					<!-- /wp:separator -->

					<!-- wp:paragraph {"style":{"typography":{"textAlign":"center"}}} -->
					<p class="has-text-align-center">First frost.</p>
					<!-- /wp:paragraph -->

				</div>
				<!-- /wp:group -->

			</footer>
			<!-- /wp:group -->

		</article>
		<!-- /wp:group -->

	</main>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/story-navigation-default-full"} /-->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/canvas-scene-flow-field"} /-->

</div>
<!-- /wp:group -->
