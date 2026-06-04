<?php

/**
 * Title: Chapter 2 — The Map I Drew
 * Slug: x3p0-a-boy-in-the-wild/chapter-002
 * Description: Starter pattern for Chapter 2..
 * Categories: x3p0-chapters
 * Inserter: true
 */

declare(strict_types=1);

use X3P0\ABoyInTheWild\Block\Binding\Sources\Chapter;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterField;

$map =  get_theme_file_uri('public/media/images/chapter/002-map.webp');
?>

<!-- wp:group {
	"metadata":{"name":"<?= esc_attr__('Entry', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full",
	"className":"is-style-section-season-early-autumn",
	"style":{
		"spacing":{"padding":{"bottom":"var:preset|spacing|70","top":"var:preset|spacing|70"}},
		"css":"--wp--custom--mark--separator: '\\00d7';"
	},
	"layout":{"type":"constrained","contentSize":"64rem","wideSize":"80rem"}
} -->
<div class="wp-block-group alignfull is-style-section-season-early-autumn has-custom-css" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/waypoint-default-full"} /-->

	<!-- wp:image {
		"id":516,
		"sizeSlug":"full",
		"linkDestination":"none",
		"metadata":{"name":"<?= esc_attr__('Map', 'x3p0-a-boy-in-the-wild') ?>"},
		"align":"full",
		"className":"is-style-image-sketch"
	} -->
	<figure class="wp-block-image alignfull size-full is-style-image-sketch"><img src="<?= esc_url($map) ?>" alt="A hand-drawn territory map on parchment, showing contour lines, two ridges, and four named locations marked with pins. One location — The Place Where I Buried Something — is marked with an X in the far corner." class="wp-image-516"/><figcaption class="wp-element-caption">Scale: about a day's walk. Maybe two.</figcaption></figure>
	<!-- /wp:image -->

	<!-- wp:group {
		"tagName":"main",
		"metadata":{"name":"<?= esc_attr__('Frame', 'x3p0-a-boy-in-the-wild') ?>"},
		"layout":{"type":"default"}
	} -->
	<main class="wp-block-group">

		<!-- wp:group {
			"tagName":"article",
			"metadata":{"name":"<?= esc_attr__('Chapter', 'x3p0-a-boy-in-the-wild') ?>"},
			"align":"full",
			"layout":{"type":"default"}
		} -->
		<article class="wp-block-group alignfull">

			<!-- wp:group {
				"tagName":"header",
				"metadata":{"name":"<?= esc_attr__('Chapter Header', 'x3p0-a-boy-in-the-wild') ?>"},
				"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
				"layout":{"type":"default"}
			} -->
			<header class="wp-block-group">

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/chapter-dateline"} /-->

				<!-- wp:post-title {
					"level":1,
					"placeholder": "<?= esc_attr__('The Map I Drew', 'x3p0-a-boy-in-the-wild') ?>",
					"className":"is-style-text-poster"
				} /-->

			</header>
			<!-- /wp:group -->

			<!-- wp:separator {"className":"is-style-separator-draw"} -->
			<hr class="wp-block-separator has-alpha-channel-opacity is-style-separator-draw"/>
			<!-- /wp:separator -->

			<!-- wp:group {
				"metadata":{"name":"<?= esc_attr__('Chapter Content', 'x3p0-a-boy-in-the-wild') ?>"},
				"className":"is-style-prose",
				"style":{"spacing":{"padding":{"right":"var:preset|spacing|0","left":"var:preset|spacing|0"}}},
				"layout":{"type":"constrained","contentSize":"64rem"}
			} -->
			<div class="wp-block-group is-style-prose" style="padding-right:var(--wp--preset--spacing--0);padding-left:var(--wp--preset--spacing--0)">

				<!-- wp:columns -->
				<div class="wp-block-columns">

					<!-- wp:column {
						"width":"55%",
						"metadata":{"name":"<?= esc_attr__('Intro', 'x3p0-a-boy-in-the-wild') ?>"}
					} -->
					<div class="wp-block-column" style="flex-basis:55%">

						<!-- wp:paragraph {"dropCap":true} -->
						<p class="has-drop-cap">I have named twelve things. The ridge was first because it was the largest and because I could see it from everywhere and because it seemed wrong that something that size should go unnamed. I called it <em>My Ridge</em>. This is its name.</p>
						<!-- /wp:paragraph -->

					</div>
					<!-- /wp:column -->

					<!-- wp:column {
						"width":"45%",
						"metadata":{"name":"<?= esc_attr__('Stats', 'x3p0-a-boy-in-the-wild') ?>"},
						"style":{"spacing":{"blockGap":"var:preset|spacing|0"}}
					} -->
					<div class="wp-block-column" style="flex-basis:45%">

						<!-- wp:separator {"tagName":"div"} -->
						<div class="wp-block-separator has-alpha-channel-opacity"></div>
						<!-- /wp:separator -->

						<!-- wp:group {
							"style":{"spacing":{"blockGap":"var:preset|spacing|10","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},
							"layout":{"type":"flex","orientation":"vertical","rowGap":"0"}
						} -->
						<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">

							<!-- wp:paragraph {"className":"is-style-text-subhead" } -->
							<p class="is-style-text-subhead">12</p>
							<!-- /wp:paragraph -->

							<!-- wp:paragraph {"className":"is-style-text-caption"} -->
							<p class="is-style-text-caption">things named</p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

						<!-- wp:separator {"tagName":"div"} -->
						<div class="wp-block-separator has-alpha-channel-opacity"></div>
						<!-- /wp:separator -->

						<!-- wp:group {
							"style":{"spacing":{"blockGap":"var:preset|spacing|10","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},
							"layout":{"type":"flex","orientation":"vertical","rowGap":"0"}
						} -->
						<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">

							<!-- wp:paragraph {
								"metadata":{
									"name":"<?= esc_attr__('Day (Number)', 'x3p0-a-boy-in-the-wild') ?>",
									"bindings":{
										"content":{
											"source":"<?= esc_attr(Chapter::NAME) ?>",
											"args":{"field":"<?= esc_attr(ChapterField::Day->value) ?>"}
										}
									}
								},
								"className":"is-style-text-subhead"
							} -->
							<p class="is-style-text-subhead">51</p>
							<!-- /wp:paragraph -->

							<!-- wp:paragraph {"className":"is-style-text-caption"} -->
							<p class="is-style-text-caption">days in the wild</p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

						<!-- wp:separator {"tagName":"div"} -->
						<div class="wp-block-separator has-alpha-channel-opacity"></div>
						<!-- /wp:separator -->

						<!-- wp:group {
							"style":{"spacing":{"blockGap":"var:preset|spacing|10","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40"}}},
							"layout":{"type":"flex","orientation":"vertical","rowGap":"0"}
						} -->
						<div class="wp-block-group" style="padding-top:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40)">

							<!-- wp:paragraph {"className":"is-style-text-subhead" } -->
							<p class="is-style-text-subhead">1</p>
							<!-- /wp:paragraph -->

							<!-- wp:paragraph {"className":"is-style-text-caption"} -->
							<p class="is-style-text-caption">thing buried</p>
							<!-- /wp:paragraph -->

						</div>
						<!-- /wp:group -->

						<!-- wp:separator {"tagName":"div"} -->
						<div class="wp-block-separator has-alpha-channel-opacity"></div>
						<!-- /wp:separator -->

					</div>
					<!-- /wp:column -->

				</div>
				<!-- /wp:columns -->

				<!-- wp:separator {"tagName":"div"} -->
				<div class="wp-block-separator has-alpha-channel-opacity"></div>
				<!-- /wp:separator -->

				<!-- wp:quote {"className":"is-style-quote-display"} -->
				<blockquote class="wp-block-quote is-style-quote-display">
					<!-- wp:paragraph -->
					<p>I knew every path. I made most of them up.</p>
					<!-- /wp:paragraph -->
				</blockquote>
				<!-- /wp:quote -->

				<!-- wp:separator {"tagName":"div"} -->
				<div class="wp-block-separator has-alpha-channel-opacity"></div>
				<!-- /wp:separator -->

				<!-- wp:group {
					"metadata":{"name":"<?= esc_attr__('Places', 'x3p0-a-boy-in-the-wild') ?>"},
					"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
					"layout":{"type":"grid","columnCount":2}
				} -->
				<div class="wp-block-group">

					<!-- wp:group {
						"className":"is-style-container-bordered",
						"style":{"spacing":{"blockGap":"var:preset|spacing|10","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},
						"layout":{"type":"flex","orientation":"vertical"}
					} -->
					<div class="wp-block-group is-style-container-bordered" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">

						<!-- wp:heading {"className":"is-style-text-caption"} -->
						<h2 class="wp-block-heading is-style-text-caption">The Hollow</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p>A depression between two root systems where the ground stays soft. I slept here twice. The second time I did not mean to. It is the kind of place that takes you in without asking, which I understand.</p>
						<!-- /wp:paragraph -->

					</div>
					<!-- /wp:group -->

					<!-- wp:group {
						"className":"is-style-container-bordered",
						"style":{"spacing":{"blockGap":"var:preset|spacing|10","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},
						"layout":{"type":"flex","orientation":"vertical"}
					} -->
					<div class="wp-block-group is-style-container-bordered" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">

						<!-- wp:heading {"className":"is-style-text-caption"} -->
						<h2 class="wp-block-heading is-style-text-caption">My Ridge</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p>I named it after myself. Later I found out it already had a name. I kept mine. The other name was wrong anyway.</p>
						<!-- /wp:paragraph -->

					</div>
					<!-- /wp:group -->

					<!-- wp:group {
						"className":"is-style-container-bordered",
						"style":{"spacing":{"blockGap":"var:preset|spacing|10","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},
						"layout":{"type":"flex","orientation":"vertical"}
					} -->
					<div class="wp-block-group is-style-container-bordered" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">

						<!-- wp:heading {"className":"is-style-text-caption"} -->
						<h2 class="wp-block-heading is-style-text-caption">The Creek That Lied</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p>Once about its depth. Once about its direction. I do not apologize to it when I cross it, which I think it knows.</p>
						<!-- /wp:paragraph -->

					</div>
					<!-- /wp:group -->

					<!-- wp:group {
						"className":"is-style-container-bordered",
						"style":{"spacing":{"blockGap":"var:preset|spacing|10","padding":{"top":"var:preset|spacing|40","bottom":"var:preset|spacing|40","left":"var:preset|spacing|40","right":"var:preset|spacing|40"}}},
						"layout":{"type":"flex","orientation":"vertical"}
					} -->
					<div class="wp-block-group is-style-container-bordered" style="padding-top:var(--wp--preset--spacing--40);padding-right:var(--wp--preset--spacing--40);padding-bottom:var(--wp--preset--spacing--40);padding-left:var(--wp--preset--spacing--40)">

						<!-- wp:heading {"className":"is-style-text-caption"} -->
						<h2 class="wp-block-heading is-style-text-caption">The Unnamed Place</h2>
						<!-- /wp:heading -->

						<!-- wp:paragraph -->
						<p>I have been here four times. Each time I mean to name it. Each time I leave without doing it. Some places resist naming.</p>
						<!-- /wp:paragraph -->

					</div>
					<!-- /wp:group -->

				</div>
				<!-- /wp:group -->

				<!-- wp:group {
					"className":"is-style-container-elevated",
					"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70","right":"var:preset|spacing|70"},"blockGap":"var:preset|spacing|10"}},
					"layout":{"type":"flex","orientation":"vertical"}
				} -->
				<div class="wp-block-group is-style-container-elevated" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

					<!-- wp:heading {"className":"is-style-text-caption"} -->
					<h2 class="wp-block-heading is-style-text-caption">The Place Where I Buried Something</h2>
					<!-- /wp:heading -->

					<!-- wp:paragraph -->
					<p>I buried it on the third day when I was certain no one was watching. It is wrapped in <span class="redacted">the shirt I was wearing when I arrived here. The location</span> on the map is deliberately wrong. I will know where it actually is.</p>
					<!-- /wp:paragraph -->

					<!-- wp:paragraph {"className":"is-style-text-caption"} -->
					<p class="is-style-text-caption">I know what it is. I'm not ready.</p>
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
				"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}
			} -->
			<footer class="wp-block-group is-style-container-meta">

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/fragment-chapter-season"} /-->

				<!-- wp:separator {"tagName":"div","className":"is-style-separator-inline"} -->
				<div class="wp-block-separator has-alpha-channel-opacity is-style-separator-inline"></div>
				<!-- /wp:separator -->

				<!-- wp:post-title {"level":6} /-->

			</footer>
			<!-- /wp:group -->

		</article>
		<!-- /wp:group -->

	</main>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/story-navigation-default"} /-->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/canvas-scene-motes"} /-->

</div>
<!-- /wp:group -->
