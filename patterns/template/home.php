<?php

/**
 * Title: Home Template
 * Slug: x3p0-a-boy-in-the-wild/template-home
 * Inserter: no
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

$background = get_theme_file_uri('public/media/images/system/season-late-summer.webp');
$sketch     = get_theme_file_uri('public/media/images/template/home-sketch.webp');
?>

<!-- wp:group {
	"className":"is-style-section-season-late-summer",
	"metadata":{"name":"<?= esc_attr__('The Territory', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full",
	"style":{
		"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70","right":"var:preset|spacing|70"},"margin":{"top":"0"}},
		"background":{"backgroundImage":{"url":"<?= esc_url($background) ?>","id":419,"source":"file","title":"late-summer-background"},"backgroundSize":"cover","backgroundPosition":"50% 0%","backgroundAttachment":"fixed"}
	},
	"layout":{"type":"default"}
} -->
<div class="wp-block-group alignfull is-style-section-season-late-summer" style="margin-top:0;padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

	<!-- wp:columns {
		"metadata":{"name":"<?= esc_attr__('The Layout', 'x3p0-a-boy-in-the-wild') ?>"},
		"className":"home-grid",
		"style":{"spacing":{"blockGap":{"left":"var:preset|spacing|90"}}}
	} -->
	<div class="wp-block-columns home-grid">

		<!-- wp:column {
			"metadata":{"name":"<?= esc_attr__('The Marker', 'x3p0-a-boy-in-the-wild') ?>"},
			"width":"38%"
		} -->
		<div class="wp-block-column" style="flex-basis:38%">

			<!-- wp:group {
				"tagName":"header",
				"metadata":{"name":"<?= esc_attr__('The Anchor', 'x3p0-a-boy-in-the-wild') ?>"},
				"style":{"position":{"type":"sticky","top":"0px"}},
				"layout":{"type":"default"}
			} -->
			<header class="wp-block-group">

				<!-- wp:group {
					"metadata":{"name":"<?= esc_attr__('The Brand', 'x3p0-a-boy-in-the-wild') ?>"},
					"style":{"spacing":{"blockGap":"var:preset|spacing|20"}},
					"layout":{"type":"flex","flexWrap":"nowrap"}
				} -->
				<div class="wp-block-group">

					<!-- wp:site-logo {"width":25} /-->

					<!-- wp:site-title {
						"isLink":false,
						"metadata":{"name":"<?= esc_attr__('The Title', 'x3p0-a-boy-in-the-wild') ?>"}
					} /-->

				</div>
				<!-- /wp:group -->

				<!-- wp:group {
					"metadata":{"name":"<?= esc_attr__('The Opening', 'x3p0-a-boy-in-the-wild') ?>"},
					"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},
					"layout":{"type":"default"}
				} -->
				<div class="wp-block-group">


					<!-- wp:heading {"level":1} -->
					<h1 class="wp-block-heading"><?= wp_kses_post(__('<strong>Mostly</strong> <em><span class="has-ink-subtle-color">true</mark></em>', 'x3p0-a-boy-in-the-wild')) ?></h1>
					<!-- /wp:heading -->

					<!-- wp:paragraph {"className":"is-style-text-caption"} -->
					<p class="is-style-text-caption"><?= esc_html__('Notes on finding the way back, chronicled one marker at a time. The path shifts, but the direction holds.', 'x3p0-a-boy-in-the-wild') ?></p>
					<!-- /wp:paragraph -->

				</div>
				<!-- /wp:group -->

				<!-- wp:image {
					"metadata":{"name":"<?= esc_attr__('The Sketch', 'x3p0-a-boy-in-the-wild') ?>"},
					"sizeSlug":"large",
					"className":"is-style-image-sketch"
				} -->
				<figure class="wp-block-image size-large is-style-image-sketch"><img src="<?= esc_url($sketch) ?>" alt=""/><figcaption class="wp-element-caption"><?= esc_html__('Somewhere north of the ridge', 'x3p0-a-boy-in-the-wild') ?></figcaption></figure>
				<!-- /wp:image -->

			</header>
			<!-- /wp:group -->

		</div>
		<!-- /wp:column -->

		<!-- wp:column {
			"metadata":{"name":"<?= esc_attr__('The Trail', 'x3p0-a-boy-in-the-wild') ?>"},
			"width":"62%"
		} -->
		<div class="wp-block-column" style="flex-basis:62%">

			<!-- wp:group {
				"tagName":"main",
				"metadata":{"name":"<?= esc_attr__('The Chronicle', 'x3p0-a-boy-in-the-wild') ?>"},
				"layout":{"type":"default"}
			} -->
			<main class="wp-block-group">

				<!-- wp:group {
					"metadata":{"name":"<?= esc_attr__('The Heading', 'x3p0-a-boy-in-the-wild') ?>"},
					"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
					"layout":{"type":"default"}
				} -->
				<div class="wp-block-group">

					<!-- wp:group {
						"metadata":{"name":"<?= esc_attr__('The Kicker', 'x3p0-a-boy-in-the-wild') ?>"},
						"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
						"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}
					} -->
					<div class="wp-block-group">

						<!-- wp:heading {"className":"is-style-text-kicker"} -->
						<h2 class="wp-block-heading is-style-text-kicker"><?= esc_html__('The Trail So Far', 'x3p0-a-boy-in-the-wild') ?></h2>
						<!-- /wp:heading -->

						<!-- wp:icon {"icon":"x3p0/compass","metadata":{"name":"<?= esc_attr__('Compass', 'x3p0-a-boy-in-the-wild') ?>"},"style":{"dimensions":{"width":"40px"}}} /-->

					</div>
					<!-- /wp:group -->

					<!-- wp:separator {"opacity":"css"} -->
					<hr class="wp-block-separator has-css-opacity"/>
					<!-- /wp:separator -->

				</div>
				<!-- /wp:group -->

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/query-trail"} /-->

				<!-- wp:separator {"opacity":"css"} -->
				<hr class="wp-block-separator has-css-opacity"/>
				<!-- /wp:separator -->

				<!-- wp:buttons {"metadata":{"name":"<?= esc_attr__('The Beginning', 'x3p0-a-boy-in-the-wild') ?>"}} -->
				<div class="wp-block-buttons">

					<!-- wp:button {"metadata":{"bindings":{"url":{"source":"x3p0/story","args":{"field":"firstChapterUrl"}},"text":{"source":"x3p0/story","args":{"field":"firstChapterLabel"}}}},"className":"is-style-button-link"} -->
					<div class="wp-block-button is-style-button-link"><a class="wp-block-button__link wp-element-button" href="/"><?= esc_html__('Begin at the beginning →', 'x3p0-a-boy-in-the-wild') ?></a></div>
					<!-- /wp:button -->

				</div>
				<!-- /wp:buttons -->

			</main>
			<!-- /wp:group -->

		</div>
		<!-- /wp:column -->

	</div>
	<!-- /wp:columns -->

</div>
<!-- /wp:group -->
