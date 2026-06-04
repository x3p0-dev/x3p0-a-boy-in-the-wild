<?php

/**
 * Theme application class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild;

use X3P0\ABoyInTheWild\Framework\Core\Application;

/**
 * The Theme class is an implementation of the Application contract. It's used
 * to register the default service providers, bootstrapping the theme.
 */
final class Theme extends Application
{
	/**
	 * Defines the theme's namespace, which is used as a hook prefix.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	protected const NAMESPACE = 'x3p0/a-boy-in-the-wild';

	/**
	 * Defines the theme's default service providers.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	protected const PROVIDERS = [
		Admin\AdminServiceProvider::class,
		Audio\AudioServiceProvider::class,
		Block\Binding\BindingServiceProvider::class,
		Block\Canvas\CanvasServiceProvider::class,
		Block\Category\BlockCategoryServiceProvider::class,
		Block\Render\RenderServiceProvider::class,
		Block\Settings\SettingsServiceProvider::class,
		Block\Style\StyleServiceProvider::class,
		Block\Stylesheet\StylesheetServiceProvider::class,
		Content\ContentServiceProvider::class,
		Editor\EditorServiceProvider::class,
		Frontend\FrontendServiceProvider::class,
		Icon\IconServiceProvider::class,
		Pattern\PatternServiceProvider::class,
		Rest\RestServiceProvider::class,
		Story\StoryServiceProvider::class,
		Template\TemplateServiceProvider::class
	];
}
