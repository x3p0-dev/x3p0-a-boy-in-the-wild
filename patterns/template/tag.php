<?php

/**
 * Title: Tag Template
 * Slug: x3p0-a-boy-in-the-wild/template-tag
 * Inserter: no
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

use X3P0\ABoyInTheWild\Icon\Icon;
use X3P0\ABoyInTheWild\Media\Image;
?>

<!-- wp:group {
	"className":"is-style-section-season-late-summer",
	"metadata":{"name":"<?= esc_attr__('The Territory', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full",
	"style":{
		"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70","right":"var:preset|spacing|70"},"margin":{"top":"0"}},
		"background":{
			"backgroundImage":{
				"url":"<?= esc_url(Image::SystemSeasonLateSummer->url()) ?>",
				"id":419,
				"source":"file",
				"title":"late-summer-background"
			},
			"backgroundSize":"cover",
			"backgroundPosition":"50% 0%",
			"backgroundAttachment":"fixed"
		}
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

					<!-- wp:paragraph {"className":"is-style-text-kicker"} -->
					<p class="is-style-text-kicker"><?= esc_html__('Arc', 'x3p0-a-boy-in-the-wild') ?></p>
					<!-- /wp:paragraph -->

					<!-- wp:query-title {
						"type":"archive",
						"showPrefix":false,
						"align":"wide"
					} /-->

					<!-- wp:term-description {"className":"is-style-text-caption"} /-->

				</div>
				<!-- /wp:group -->

				<!-- wp:image {
					"metadata":{"name":"<?= esc_attr__('The Sketch', 'x3p0-a-boy-in-the-wild') ?>"},
					"sizeSlug":"large",
					"className":"is-style-image-sketch"
				} -->
				<figure class="wp-block-image size-large is-style-image-sketch"><img src="<?= esc_url(Image::TemplateArcSketch->url()) ?>" alt=""/><figcaption class="wp-element-caption"><?= esc_html__('Everything connects if you follow it long enough.', 'x3p0-a-boy-in-the-wild') ?></figcaption></figure>
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
						"className":"is-style-container-meta",
						"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
						"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}
					} -->
					<div class="wp-block-group is-style-container-meta">

						<!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"x3p0/term","args":{"field":"count"}}}},"className":"is-style-text-kicker"} -->
						<p class="is-style-text-kicker"><?= esc_html__('0 Chapters', 'x3p0-a-boy-in-the-wild') ?></p>
						<!-- /wp:paragraph -->

						<!-- wp:icon {
							"icon":"<?= esc_attr(Icon::Route->value) ?>",
							"style":{"dimensions":{"width":"40px"}}
						} /-->

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
