<?php

/**
 * Title: Animation: Flow Field
 * Slug: x3p0-a-boy-in-the-wild/canvas-scene-flow-field
 * Description: Flowing field of lines.
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
<canvas class="<?= esc_attr(Canvas::SceneFlowField->classes()) ?>"></canvas>
<!-- /wp:html -->
