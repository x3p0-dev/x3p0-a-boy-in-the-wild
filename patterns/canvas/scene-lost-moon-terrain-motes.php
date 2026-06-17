<?php

/**
 * Title: Animation: Moon, Terrain, and Motes
 * Slug: x3p0-a-boy-in-the-wild/canvas-scene-lost-moon-terrain-motes
 * Description: Rainfall.
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
<canvas class="<?= esc_attr(Canvas::SceneLostMoon->classes()) ?>" data-moon-x="0.4"></canvas>
<canvas class="<?= esc_attr(Canvas::SceneLostTerrain->classes()) ?>"></canvas>
<canvas class="<?= esc_attr(Canvas::SceneLostMotes->classes()) ?>" data-origin-x-min="0.24" data-origin-x-max="0.56"></canvas>
<!-- /wp:html -->
