<?php

/**
 * Title: Chapter 3 — The Storm
 * Slug: x3p0-a-boy-in-the-wild/chapter-003
 * Description: Starter pattern for Chapter 3. Deep autumn. The storm. Age 12.
 * Categories: x3p0-chapters
 * Inserter: true
 */

declare(strict_types=1);

$background = get_theme_file_uri('public/media/images/chapter/003-storm.webp');
?>

<!-- wp:group {
	"metadata":{"name":"<?= esc_attr__('Entry', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full","className":"is-style-section-mood-storm",
	"style":{
		"background":{
			"backgroundImage":{
				"url":"<?= esc_url($background) ?>",
				"id":69,
				"source":"file",
				"title":"boy-in-the-wold-storm"
			},
			"backgroundSize":"cover",
			"backgroundAttachment":"fixed",
			"backgroundPosition":"0% 0%"
		},
		"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70"}},
		"css":"--wp--custom--mark--separator: '\\2014';"
	},
	"layout":{"type":"constrained"}
} -->
<div class="wp-block-group alignfull is-style-section-mood-storm has-custom-css" style="padding-top:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70)">

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
				"align":"full",
				"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"right":"var:preset|spacing|70","left":"var:preset|spacing|70"}}},
				"layout":{"type":"default"}
			} -->
			<header class="wp-block-group alignfull" style="padding-right:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/chapter-dateline"} /-->

				<!-- wp:post-title {"level":1,"className":"is-style-text-poster"} /-->

				<!-- wp:paragraph -->
				<p><em>It lasted one night. In my version it lasts considerably longer.</em></p>
				<!-- /wp:paragraph -->

			</header>
			<!-- /wp:group -->

			<!-- wp:group {
				"metadata":{"name":"<?= esc_attr__('Chapter Content', 'x3p0-a-boy-in-the-wild') ?>"},
				"align":"full",
				"className":"is-style-container-prose",
				"layout":{"type":"constrained"}
			} -->
			<div class="wp-block-group alignfull is-style-container-prose">

				<!-- wp:separator {"opacity":"css","className":"is-style-separator-chapter-rule"} -->
				<hr class="wp-block-separator has-css-opacity is-style-separator-chapter-rule"/>
				<!-- /wp:separator -->

				<!-- wp:paragraph {"dropCap":true} -->
				<p class="has-drop-cap">The hollow is not a good place to wait out a storm. It is the place I was when the storm started and so it became the place I waited. This is how most decisions get made when you are twelve years old and there is no one to make them with you.</p>
				<!-- /wp:paragraph -->

				<!-- wp:paragraph -->
				<p>The tree that fell across the entrance fell in the first hour. After that I was inside something. I am not sure what to call it. A room. A trap. A luck.</p>
				<!-- /wp:paragraph -->

				<!-- wp:columns {
					"align":"wide",
					"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|70","left":"var:preset|spacing|70"}}}
				} -->
				<div class="wp-block-columns alignwide">

					<!-- wp:column {"width":"55%"} -->
					<div class="wp-block-column" style="flex-basis:55%">

						<!-- wp:paragraph -->
						<p>The wind had a direction. Then it had several directions. Then it had no direction I could name.</p>
						<!-- /wp:paragraph -->

						<!-- wp:paragraph -->
						<p>I had built a fire two days before. The fire was gone. I did not try to rebuild it. There are moments when the right decision is to not try.</p>
						<!-- /wp:paragraph -->

					</div>
					<!-- /wp:column -->

					<!-- wp:column {"width":"45%"} -->
					<div class="wp-block-column" style="flex-basis:45%">

						<!-- wp:list {"className":"is-style-list-fade-out"} -->
						<ul class="wp-block-list is-style-list-fade-out">
							<!-- wp:list-item -->
							<li>Wind in the upper canopy.</li>
							<!-- /wp:list-item -->

							<!-- wp:list-item -->
							<li>Something moving. Not close.</li>
							<!-- /wp:list-item -->

							<!-- wp:list-item -->
							<li>Rain on the left side of everything.</li>
							<!-- /wp:list-item -->

							<!-- wp:list-item -->
							<li>My own breathing.</li>
							<!-- /wp:list-item -->

							<!-- wp:list-item -->
							<li>Something moving. Closer.</li>
							<!-- /wp:list-item -->

							<!-- wp:list-item -->
							<li>Rain on everything now.</li>
							<!-- /wp:list-item -->

							<!-- wp:list-item -->
							<li>My own breathing.</li>
							<!-- /wp:list-item -->

							<!-- wp:list-item -->
							<li>My own breathing.</li>
							<!-- /wp:list-item -->
						</ul>
						<!-- /wp:list -->

					</div>
					<!-- /wp:column -->

				</div>
				<!-- /wp:columns -->

				<!-- wp:paragraph {"className":"is-style-text-aside"} -->
				<p class="is-style-text-aside">I thought about the fire from the first night and whether it had been large enough and whether —</p>
				<!-- /wp:paragraph -->

				<!-- wp:separator -->
				<hr class="wp-block-separator has-alpha-channel-opacity"/>
				<!-- /wp:separator -->

				<!-- wp:verse -->
				<pre class="wp-block-verse">If I get out I will not tell anyone how scared I was.<br>Or I will tell everyone.<br>I haven’t decided yet.<br><br>There is no one to tell anyway.</pre>
				<!-- /wp:verse -->

				<!-- wp:separator -->
				<hr class="wp-block-separator has-alpha-channel-opacity"/>
				<!-- /wp:separator -->

				<!-- wp:paragraph -->
				<p>I tried to sleep. <span class="redacted">I thought about my family for the first time since the first night. I am not going to write about that.</span></p>
				<!-- /wp:paragraph -->

				<!-- wp:spacer {"height":"var:preset|spacing|110"} -->
				<div style="height:var(--wp--preset--spacing--110)" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:paragraph -->
				<p class="has-text-color">By the time the light came back the rain had mostly stopped. The tree was still there. I could get under it if I stayed low. I stayed low.</p>
				<!-- /wp:paragraph -->

				<!-- wp:spacer {"height":"var:preset|spacing|110"} -->
				<div style="height:var(--wp--preset--spacing--110)" aria-hidden="true" class="wp-block-spacer"></div>
				<!-- /wp:spacer -->

				<!-- wp:paragraph {"className":"is-style-text-declaration"} -->
				<p class="is-style-text-declaration">I got out.</p>
				<!-- /wp:paragraph -->

			</div>
			<!-- /wp:group -->

			<!-- wp:group {
				"tagName":"footer",
				"metadata":{"name":"<?= esc_attr__('Chapter Footer', 'x3p0-a-boy-in-the-wild') ?>"},
				"align":"full",
				"className":"is-style-container-meta",
				"style":{"spacing":{"blockGap":"var:preset|spacing|20","padding":{"right":"var:preset|spacing|70","left":"var:preset|spacing|70"}}},
				"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"right"}
			} -->
			<footer class="wp-block-group alignfull is-style-container-meta" style="padding-right:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/fragment-chapter-season"} /-->

				<!-- wp:separator {"tagName":"div","className":"is-style-separator-inline"} -->
				<div class="wp-block-separator has-alpha-channel-opacity is-style-separator-inline"></div>
				<!-- /wp:separator -->

				<!-- wp:post-title {"level":6} /-->

				<!-- wp:separator {"tagName":"div","className":"is-style-separator-inline"} -->
				<div class="wp-block-separator has-alpha-channel-opacity is-style-separator-inline"></div>
				<!-- /wp:separator -->

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/fragment-story-year"} /-->

			</footer>
			<!-- /wp:group -->

		</article>
		<!-- /wp:group -->

	</main>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/story-navigation-default-full"} /-->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/canvas-bg-storm"} /-->

</div>
<!-- /wp:group -->
