<?php

/**
 * Icon registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-ideas
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Icon;

use ReflectionException;
use ReflectionMethod;
use WP_Icons_Registry;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Handles registering icons.
 */
final class IconRegistrar implements Bootable
{
	private const NAMESPACE = 'x3p0';

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('init', $this->register(...));
	}

	/**
	 * Registers custom icons.
	 *
	 * @throws ReflectionException
	 */
	private function register(): void
	{
		$registry = WP_Icons_Registry::get_instance();

		try {
			$method = new ReflectionMethod(WP_Icons_Registry::class, 'register');
		} catch (ReflectionException) {
			return;
		}

		foreach ($this->icons() as $name => $label) {
			$method->invoke($registry, self::NAMESPACE . "/{$name}", [
				'label'    => $label,
				'filePath' => get_parent_theme_file_path("public/media/svg/{$name}.svg")
			]);
		}
	}

	/**
	 * Returns an array of icons.
	 */
	private function icons(): array
	{
		return [
			'compass'    => __('Compass', 'x3p0-a-boy-in-the-wild'),
			'sealed-key' => __('Sealed Key', 'x3p0-a-boy-in-the-wild')
		];
	}
}
