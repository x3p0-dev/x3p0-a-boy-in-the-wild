<?php

/**
 * Icon registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
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
	 * Returns an array of icons.
	 */
	private function icons(): array
	{
		return [
			'bird-horizon' => __('Bird Horizon', 'x3p0-a-boy-in-the-wild'),
			'compass'      => __('Compass',      'x3p0-a-boy-in-the-wild'),
			'crosshair'    => __('Crosshair',    'x3p0-a-boy-in-the-wild'),
			'draw'         => __('Draw',         'x3p0-a-boy-in-the-wild'),
			'route'        => __('Route',        'x3p0-a-boy-in-the-wild'),
			'sealed-key'   => __('Sealed Key',   'x3p0-a-boy-in-the-wild'),
			'sundial'      => __('Sundial',      'x3p0-a-boy-in-the-wild'),
			'sun-path'     => __('Sun Path',     'x3p0-a-boy-in-the-wild')
		];
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
}
