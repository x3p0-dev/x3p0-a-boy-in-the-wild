<?php

/**
 * Title: Category Template
 * Slug: x3p0-a-boy-in-the-wild/template-category
 * Inserter: no
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

$background = get_theme_file_uri('public/media/images/late-summer-background.webp');
$sketch     = get_theme_file_uri('public/media/images/era-sketch.webp');
?>

<!-- wp:group {"className":"is-style-season-late-summer","metadata":{"name":"The Territory"},"align":"full","style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70","right":"var:preset|spacing|70"},"margin":{"top":"0"}},"background":{"backgroundImage":{"url":"<?= esc_url($background) ?>","id":419,"source":"file","title":"late-summer-background"},"backgroundSize":"cover","backgroundPosition":"50% 0%","backgroundAttachment":"fixed"}},"layout":{"type":"default"}} -->
<div class="wp-block-group alignfull is-style-season-late-summer" style="margin-top:0;padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

	<!-- wp:columns {"metadata":{"name":"The Layout"},"className":"home-grid","style":{"spacing":{"blockGap":{"left":"var:preset|spacing|90"}}}} -->
	<div class="wp-block-columns home-grid">

		<!-- wp:column {"metadata":{"name":"The Marker"},"width":"38%"} -->
		<div class="wp-block-column" style="flex-basis:38%">

			<!-- wp:group {"tagName":"header","metadata":{"name":"The Anchor"},"style":{"position":{"type":"sticky","top":"0px"}},"layout":{"type":"default"}} -->
			<header class="wp-block-group">

				<!-- wp:site-title {"metadata":{"name":"The Title"}} /-->

				<!-- wp:group {"metadata":{"name":"The Opening"},"style":{"spacing":{"blockGap":"var:preset|spacing|10"}},"layout":{"type":"default"}} -->
				<div class="wp-block-group">

					<!-- wp:paragraph {"className":"is-style-text-kicker"} -->
					<p class="is-style-text-kicker">Era</p>
					<!-- /wp:paragraph -->

					<!-- wp:query-title {
						"type":"archive",
						"showPrefix":false,
						"align":"wide"
					} /-->

					<!-- wp:term-description {
						"metadata":{
						"x3p0/rules":{"rules":[{"type": "unless", "callback":"is_paged"}]}
						},
						"className": "is-style-text-caption"
					} /-->

				</div>
				<!-- /wp:group -->

				<!-- wp:image {"metadata":{"name":"The Sketch"},"sizeSlug":"large","className":"is-style-image-sketch"} -->
				<figure class="wp-block-image size-large is-style-image-sketch"><img src="<?= esc_url($sketch) ?>" alt="AI_IMAGE: A quick, expressive pencil and sepia wash sketch of a distant mountain ridge line with sparse pine trees, drawn loosely on a textured journal page | illustration | landscape"/><figcaption class="wp-element-caption">The territory as I know it. Corrections pending.</figcaption></figure>
				<!-- /wp:image -->

			</header>
			<!-- /wp:group -->

		</div>
		<!-- /wp:column -->

		<!-- wp:column {"metadata":{"name":"The Trail"},"width":"62%"} -->
		<div class="wp-block-column" style="flex-basis:62%">

			<!-- wp:group {"tagName":"main","metadata":{"name":"The Chronicle"},"layout":{"type":"default"}} -->
			<main class="wp-block-group">

				<!-- wp:group {"metadata":{"name":"The Heading"},"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"default"}} -->
				<div class="wp-block-group">

					<!-- wp:group {"className":"is-style-container-meta","style":{"spacing":{"blockGap":"var:preset|spacing|40"}},"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"space-between"}} -->
					<div class="wp-block-group is-style-container-meta"><!-- wp:paragraph {"metadata":{"bindings":{"content":{"source":"x3p0/term","args":{"field":"count"}}}},"className":"is-style-text-kicker"} -->
						<p class="is-style-text-kicker">0 Chapters</p>
						<!-- /wp:paragraph -->

						<!-- wp:icon {"icon":"x3p0/sun-path","style":{"dimensions":{"width":"40px"}}} /--></div>
					<!-- /wp:group -->

					<!-- wp:separator {"opacity":"css","className":"is-style-separator-hand-drawn"} -->
					<hr class="wp-block-separator has-css-opacity is-style-separator-hand-drawn"/>
					<!-- /wp:separator -->

				</div>
				<!-- /wp:group -->

				<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/query-trail"} /-->

				<!-- wp:separator {"opacity":"css","className":"is-style-separator-hand-drawn"} -->
				<hr class="wp-block-separator has-css-opacity is-style-separator-hand-drawn"/>
				<!-- /wp:separator -->

				<!-- wp:buttons {"metadata":{"name":"The Beginning"}} -->
				<div class="wp-block-buttons">

					<!-- wp:button {"metadata":{"bindings":{"url":{"source":"x3p0/story","args":{"field":"firstChapterUrl"}},"text":{"source":"x3p0/story","args":{"field":"firstChapterLabel"}}}},"className":"is-style-button-link"} -->
					<div class="wp-block-button is-style-button-link"><a class="wp-block-button__link wp-element-button" href="/">Begin at the beginning →</a></div>
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
