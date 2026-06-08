<?php

/**
 * Title: Chapter 5 — How to Make a Fire When Everything Is Wet
 * Slug: x3p0-a-boy-in-the-wild/chapter-005
 * Description: Starter pattern for Chapter 5.
 * Categories: x3p0-chapters
 * Inserter: true
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

$background = get_theme_file_uri('public/media/images/chapter/005-campfire.webp');
?>

<!-- wp:group {
	"metadata":{"name":"<?= esc_attr__('Entry', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full",
	"className":"is-style-section-mood-campfire",
	"style":{
		"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},
		"background":{
			"backgroundImage":{
				"url":"<?= esc_url($background) ?>",
				"id":173,
				"source":"file",
				"title":"boy-in-the-wild-dark-fire"
			},
			"backgroundSize":"cover",
			"backgroundPosition":"84% 84%",
			"backgroundAttachment":"fixed"
		},
		"css":"--wp--custom--mark--separator: '\\002b';"
	},
	"layout":{"type":"constrained","contentSize":"880px","justifyContent":"center"}
} -->
<div class="wp-block-group alignfull is-style-section-mood-campfire has-custom-css" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/waypoint-default-full"} /-->

	<!-- wp:group {
		"tagName":"main",
		"metadata":{"name":"<?= esc_attr__('Frame', 'x3p0-a-boy-in-the-wild') ?>"},
		"layout":{"type":"default"}
	} -->
	<main class="wp-block-group">

		<!-- wp:group {
			"tagName":"article",
			"metadata":{"name":"<?= esc_attr__('Chapter', 'x3p0-a-boy-in-the-wild') ?>"},
			"layout":{"type":"default"}
		} -->
		<article class="wp-block-group">

			<!-- wp:group {
				"tagName":"header",
				"metadata":{"name":"<?= esc_attr__('Chapter Header', 'x3p0-a-boy-in-the-wild') ?>"},
				"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
				"layout":{"type":"constrained","justifyContent":"left"}
			} -->
			<header class="wp-block-group">

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/chapter-dateline-season-time-excerpt"} /-->

				<!-- wp:post-title {
					"level":1,
					"metadata":{"name":"<?= esc_attr__('Chapter Title', 'x3p0-a-boy-in-the-wild') ?>"}
				} /-->

				<!-- wp:separator {
					"opacity":"css",
					"className":"is-style-separator-draw"
				} -->
				<hr class="wp-block-separator has-css-opacity is-style-separator-draw"/>
				<!-- /wp:separator -->

			</header>
			<!-- /wp:group -->

			<!-- wp:group {
				"metadata":{"name":"<?= esc_attr__('Chapter Content', 'x3p0-a-boy-in-the-wild') ?>"},
				"className":"is-style-prose",
				"layout":{"type":"constrained","justifyContent":"left"}
			} -->
			<div class="wp-block-group is-style-prose">

				<!-- wp:paragraph {"dropCap":true,"className":"is-style-chapter-opener"} -->
				<p class="has-drop-cap is-style-chapter-opener">The wood was wrong. All of it. Everything I had gathered was wrong in a way I hadn't understood before — wet not on the surface but all the way through, the kind of wet that doesn't care about waiting.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>I knew the theory. I had done it before. Theory and before are <span class="redacted"><s>completely useless</s></span> less useful in deep winter at two in the morning with hands that had stopped reporting accurately on what they were touching.</p>
				<!-- /wp:paragraph -->

				<!-- wp:spacer {"height":"var:preset|spacing|70"} -->
				<div style="height:var(--wp--preset--spacing--70)" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:group {
					"metadata":{"name":"<?= esc_attr__('Attempt Log', 'x3p0-a-boy-in-the-wild') ?>"},
					"style":{"spacing":{"blockGap":"var:preset|spacing|40"}}
				} -->
				<div class="wp-block-group">

					<!-- wp:separator {"tagName":"div"} -->
					<div class="wp-block-separator has-alpha-channel-opacity"></div>
					<!-- /wp:separator -->

					<!-- wp:heading {"className":"is-style-text-caption"} -->
					<h2 class="wp-block-heading is-style-text-caption">attempts, in order</h2>
					<!-- /wp:heading -->

					<!-- wp:group {
						"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},
						"layout":{"type":"constrained"}
					} -->
					<div class="wp-block-group">

						<!-- wp:group {
							"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
							"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}
						} -->
						<div class="wp-block-group">

							<!-- wp:paragraph {
								"className":"shrink-0 is-style-text-subtle",
								"style":{"layout":{"selfStretch":"fixed","flexSize":"3rem"}}
							} -->
							<p class="shrink-0 is-style-text-subtle">1-4.</p>
							<!-- /wp:paragraph -->

							<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
							<p><s>wrong wood. too wet. no ember.</s></p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

						<!-- wp:group {
							"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
							"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}
						} -->
						<div class="wp-block-group">

							<!-- wp:paragraph {
								"className":"shrink-0 is-style-text-subtle",
								"style":{"layout":{"selfStretch":"fixed","flexSize":"3rem"}}
							} -->
							<p class="shrink-0 is-style-text-subtle">5.</p>
							<!-- /wp:paragraph -->

							<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
							<p><s>right wood, wrong technique. smoke only.</s></p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

						<!-- wp:group {
							"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
							"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}
						} -->
						<div class="wp-block-group">

							<!-- wp:paragraph {
								"className":"shrink-0 is-style-text-subtle",
								"style":{"layout":{"selfStretch":"fixed","flexSize":"3rem"}}
							} -->
							<p class="shrink-0 is-style-text-subtle">6-8.</p>
							<!-- /wp:paragraph -->

							<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
							<p><s>hands too cold to hold the bow correctly.</s></p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

						<!-- wp:group {
							"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
							"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}
						} -->
						<div class="wp-block-group">

							<!-- wp:paragraph {
								"className":"shrink-0 is-style-text-subtle",
								"style":{"layout":{"selfStretch":"fixed","flexSize":"3rem"}}
							} -->
							<p class="shrink-0 is-style-text-subtle">9.</p>
							<!-- /wp:paragraph -->

							<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
							<p><s>ember. lost it. too slow.</s></p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

						<!-- wp:group {
							"style":{
								"layout":{"selfStretch":"fit","flexSize":null},
								"spacing":{"blockGap":"var:preset|spacing|40"}
							},
							"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}
						} -->
						<div class="wp-block-group">

							<!-- wp:paragraph {
								"className":"shrink-0 is-style-text-subtle",
								"style":{"layout":{"selfStretch":"fixed","flexSize":"3rem"}}
							} -->
							<p class="shrink-0 is-style-text-subtle">10.</p>
							<!-- /wp:paragraph -->

							<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
							<p><s>ember. lost it again. not too slow. wrong tinder.</s></p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

						<!-- wp:group {
							"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
							"layout":{"type":"flex","flexWrap":"nowrap","verticalAlignment":"top"}
						} -->
						<div class="wp-block-group">

							<!-- wp:paragraph {
								"className":"shrink-0 is-style-text-subtle",
								"style":{"layout":{"selfStretch":"fixed","flexSize":"48px"}}
							} -->
							<p class="shrink-0 is-style-text-subtle">11.</p>
							<!-- /wp:paragraph -->

							<!-- wp:paragraph {"style":{"layout":{"selfStretch":"fill","flexSize":null}}} -->
							<p>fire. small. correct size for what I needed.</p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

					</div>
					<!-- /wp:group -->

					<!-- wp:separator {"tagName":"div"} -->
					<div class="wp-block-separator has-alpha-channel-opacity"></div>
					<!-- /wp:separator -->

				</div>
				<!-- /wp:group -->

				<!-- wp:paragraph {"className":"is-style-text-aside"} -->
				<p class="is-style-text-aside">The fire I made was small. It was <span class="redacted">the largest fire I have ever built</span> the right size for what I needed. I have since told this story with a larger fire. Both versions are true in the ways that matter.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"className":"is-style-text-aside"} -->
				<p class="is-style-text-aside">The important thing is to find the driest wood. Not dry wood. The driest wood available. The difference is everything. I know this now. I knew none of it then.</p>
				<!-- /wp:paragraph -->

				<!-- wp:spacer {"height":"var:preset|spacing|110"} -->
				<div style="height:var(--wp--preset--spacing--110)" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:paragraph {"className":"is-style-text-declaration","fontFamily":"headings"} -->
				<p class="is-style-text-declaration has-headings-font-family">I got out again.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph {"className":"is-style-text-caption"} -->
				<p class="is-style-text-caption">attempt eleven.</p>
				<!-- /wp:paragraph -->

			</div>
			<!-- /wp:group -->

			<!-- wp:group {
				"tagName":"footer",
				"metadata":{"name":"<?= esc_attr__('Chapter Footer', 'x3p0-a-boy-in-the-wild') ?>"},
				"className":"is-style-container-meta",
				"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
				"layout":{"type":"flex","flexWrap":"nowrap"}
			} -->
			<footer class="wp-block-group is-style-container-meta">

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/fragment-chapter-year-label"} /-->

				<!-- wp:separator {"className":"is-style-separator-inline"} -->
				<hr class="wp-block-separator has-alpha-channel-opacity is-style-separator-inline"/>
				<!-- /wp:separator -->

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/fragment-chapter-season"} /-->

			</footer>
			<!-- /wp:group -->

		</article>
		<!-- /wp:group -->

	</main>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/story-navigation-default-full"} /-->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/canvas-scene-snow-embers"} /-->

</div>
<!-- /wp:group -->
