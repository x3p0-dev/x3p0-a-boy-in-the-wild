<?php

/**
 * Title: Animation: Adrift
 * Slug: x3p0-a-boy-in-the-wild/canvas-scene-adrift
 * Description: Floating clusters of motes.
 * Categories: x3p0-canvas-scenes
 * Inserter: yes
 */

declare(strict_types=1);

use X3P0\ABoyInTheWild\Block\Canvas\Canvas;

# Prevent direct access.
defined('ABSPATH') || exit;

?>

<!-- wp:html -->
<!-- Animation canvas. Do not alter unless you know what you're doing! -->
<canvas class="<?= esc_attr(Canvas::SceneAdrift->classes()) ?>"></canvas>
<!-- /wp:html -->
