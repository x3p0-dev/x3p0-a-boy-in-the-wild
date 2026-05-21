<?php

/**
 * Title: 404 Template
 * Slug: x3p0-a-boy-in-the-wild/template-404
 * Inserter: no
 */

declare(strict_types=1);

# Prevent direct access.
defined('ABSPATH') || exit;

$sketch = get_theme_file_uri('public/media/images/template/404-sketch.webp');
?>

<!-- wp:group {
	"tagName":"main",
	"metadata":{"name":"<?= esc_attr__('Entry', 'x3p0-a-boy-in-the-wild') ?>"},
	"align":"full",
	"className":"is-style-section-mood-lost",
	"style":{"spacing":{"padding":{"top":"var:preset|spacing|70","bottom":"var:preset|spacing|70","left":"var:preset|spacing|70","right":"var:preset|spacing|70"}}},
	"layout":{"type":"constrained"}
} -->
<main class="wp-block-group alignfull is-style-section-mood-lost" style="padding-top:var(--wp--preset--spacing--70);padding-right:var(--wp--preset--spacing--70);padding-bottom:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

	<!-- wp:group {
		"metadata":{"name":"<?= esc_attr__('Waypoint', 'x3p0-a-boy-in-the-wild') ?>"},
		"align":"full",
		"className":"is-style-container-waypoint",
		"style":{"spacing":{"padding":{"right":"var:preset|spacing|70","left":"var:preset|spacing|70"}}},
		"layout":{"type":"default"}
	} -->
	<div class="wp-block-group alignfull is-style-container-waypoint" style="padding-right:var(--wp--preset--spacing--70);padding-left:var(--wp--preset--spacing--70)">

		<!-- wp:group {
			"templateLock":"contentOnly",
			"metadata":{"name":"<?= esc_attr__('Waypoint Content (Chapter)', 'x3p0-a-boy-in-the-wild') ?>"},
			"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
			"layout":{"type":"flex","flexWrap":"wrap","justifyContent":"space-between","alignItems":"center"}
		} -->
		<div class="wp-block-group">

			<!-- wp:group {
				"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
				"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}
			} -->
			<div class="wp-block-group">

				<!-- wp:site-title {"level":0} /-->

				<!-- wp:separator {"tagName":"div","className":"is-style-separator-middle-dot"} -->
				<div class="wp-block-separator has-alpha-channel-opacity is-style-separator-middle-dot"></div>
				<!-- /wp:separator -->

				<!-- wp:paragraph {"metadata":{"name":"<?= esc_attr__('Location', 'x3p0-a-boy-in-the-wild') ?>"}} -->
				<p><?= esc_html__('Unchartered', 'x3p0-a-boy-in-the-wild') ?></p>
				<!-- /wp:paragraph -->

			</div>
			<!-- /wp:group -->

			<!-- wp:buttons {
				"metadata":{"name":"<?= esc_attr__('Toggle Buttons', 'x3p0-a-boy-in-the-wild') ?>"},
				"style":{"spacing":{"blockGap":{"top":"var:preset|spacing|40","left":"var:preset|spacing|40"}}}
			} -->
			<div class="wp-block-buttons">

				<!-- wp:button {
					"tagName":"button",
					"metadata":{"name":"<?= esc_attr__('Audio Toggle', 'x3p0-a-boy-in-the-wild') ?>"},
					"className":"toggle-audio"
				} -->
				<div class="wp-block-button toggle-audio"><button type="button" class="wp-block-button__link wp-element-button"><?= esc_html__('Listen', 'x3p0-a-boy-in-the-wild') ?></button></div>
				<!-- /wp:button -->

				<!-- wp:button {
					"tagName":"button",
					"metadata":{"name":"<?= esc_attr__('Day/Night Toggle', 'x3p0-a-boy-in-the-wild') ?>"},
					"className":"toggle-color-scheme"
				} -->
				<div class="wp-block-button toggle-color-scheme"><button type="button" class="wp-block-button__link wp-element-button"><?= esc_html__('Day', 'x3p0-a-boy-in-the-wild') ?></button></div>
				<!-- /wp:button -->

			</div>
			<!-- /wp:buttons -->

		</div>
		<!-- /wp:group -->
	</div>
	<!-- /wp:group -->

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
			"align":"wide",
			"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
			"layout":{"type":"default"}
		} -->
		<header class="wp-block-group alignwide">

			<!-- wp:group {
				"className":"is-style-container-meta",
				"layout":{"type":"default"}
			} -->
			<div class="wp-block-group is-style-container-meta">
				<!-- wp:paragraph -->
				<p><?= esc_html__('Lost · Somewhere in the trees · No landmarks visible', 'x3p0-a-boy-in-the-wild') ?></p>
				<!-- /wp:paragraph -->
			</div>
			<!-- /wp:group -->

			<!-- wp:heading {"level":1} -->
			<h1 class="wp-block-heading"><?php echo wp_kses_post(__("You've gone somewhere<br>I&nbsp;<em><span class=\"has-ink-subtle-color\">haven't charted.</span></em>", 'x3p0-a-boy-in-the-wild')); ?></h1>
			<!-- /wp:heading -->

			<!-- wp:separator {"opacity":"css","className":"is-style-separator-chapter-rule"} -->
			<hr class="wp-block-separator has-css-opacity is-style-separator-chapter-rule"/>
			<!-- /wp:separator -->

		</header>
		<!-- /wp:group -->

		<!-- wp:group {
			"metadata":{"name":"<?= esc_attr__('Chapter Content', 'x3p0-a-boy-in-the-wild') ?>"},
			"align":"wide",
			"layout":{"type":"constrained","justifyContent":"left"}
		} -->
		<div class="wp-block-group alignwide">

			<!-- wp:paragraph -->
			<p><?= esc_html__("This stretch isn't on anything I've drawn. I've walked into places like this — every direction looks like every other direction, the light the same everywhere. You stop. You listen. You work out which way the water runs.", 'x3p0-a-boy-in-the-wild') ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:paragraph -->
			<p><?= wp_kses_post(__("The page you were looking for isn't here. But <em>here</em> isn't nothing. It's just unmapped. That's different. Home is back the way you came — it hasn't moved.", 'x3p0-a-boy-in-the-wild')) ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:image {"id":484,"sizeSlug":"full","linkDestination":"none","align":"wide","className":"is-style-image-sketch"} -->
			<figure class="wp-block-image alignwide size-full is-style-image-sketch"><img src="<?= esc_url($sketch) ?>" alt="" class="wp-image-484"/><figcaption class="wp-element-caption"><?= esc_html__('Not to scale · Not surveyed · Made in poor light', 'x3p0-a-boy-in-the-wild') ?></figcaption></figure>
			<!-- /wp:image -->

			<!-- wp:paragraph {"className":"is-style-text-caption"} -->
			<p class="is-style-text-caption"><?= esc_html__("If you don't know where you are, find water. It goes somewhere. Most things do.", 'x3p0-a-boy-in-the-wild') ?></p>
			<!-- /wp:paragraph -->

			<!-- wp:group {
				"style":{"spacing":{"blockGap":"var:preset|spacing|40"}},
				"layout":{"type":"flex","flexWrap":"nowrap","justifyContent":"left"}
			} -->
			<div class="wp-block-group">

				<!-- wp:buttons -->
				<div class="wp-block-buttons">

					<!-- wp:button {"metadata":{"bindings":{"url":{"source":"x3p0/site","args":{"field":"url"}}}},"className":"is-style-button-link"} -->
					<div class="wp-block-button is-style-button-link"><a class="wp-block-button__link wp-element-button" href="/"><?= esc_html__('← All Chapters', 'x3p0-a-boy-in-the-wild') ?></a></div>
					<!-- /wp:button -->

				</div>
				<!-- /wp:buttons -->

				<!-- wp:separator {"tagName":"div","className":"is-style-separator-middle-dot"} -->
				<div class="wp-block-separator has-alpha-channel-opacity is-style-separator-middle-dot"></div>
				<!-- /wp:separator -->

				<!-- wp:buttons {"metadata":{"name":"The Beginning"}} -->
				<div class="wp-block-buttons">

					<!-- wp:button {"metadata":{"bindings":{"url":{"source":"x3p0/story","args":{"field":"firstChapterUrl"}},"text":{"source":"x3p0/story","args":{"field":"firstChapterLabel"}}}},"className":"is-style-button-link"} -->
					<div class="wp-block-button is-style-button-link"><a class="wp-block-button__link wp-element-button" href="/"><?= esc_html__('Begin at the beginning →', 'x3p0-a-boy-in-the-wild') ?></a></div>
					<!-- /wp:button -->

				</div>
				<!-- /wp:buttons -->

			</div>
			<!-- /wp:group -->

		</div>
		<!-- /wp:group -->

	</article>
	<!-- /wp:group -->

	<!-- wp:pattern {"slug":"x3p0-a-boy-in-the-wild/canvas-bg-lost-moon-terrain-motes"} /-->

</main>
<!-- /wp:group -->
