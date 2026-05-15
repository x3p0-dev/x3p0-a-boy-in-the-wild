<?php

/**
 * Theme functions file, which is autoloaded by WordPress. This file is used to
 * load any other necessary PHP files and bootstrap the theme.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild;

# Prevent direct access.
defined('ABSPATH') || exit;

# Load the autoloader.
if (! class_exists(Theme::class) && is_file(__DIR__ . '/vendor/autoload.php')) {
	require_once __DIR__ . '/vendor/autoload.php';
}

add_action('after_setup_theme', fn() => theme()->boot(), -999);
