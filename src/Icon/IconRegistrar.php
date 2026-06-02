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
 * Handles registering icons with WordPress.
 */
final class IconRegistrar implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_action('init', $this->register(...));
	}

	/**
	 * Registers custom icons with the WordPress icon registry.
	 *
	 * @throws ReflectionException
	 */
	private function register(): void
	{
		$registry = WP_Icons_Registry::get_instance();

		try {
			$method = new ReflectionMethod($registry, 'register');
		} catch (ReflectionException) {
			return;
		}

		foreach (Icon::cases() as $icon) {
			$method->invoke($registry, $icon->value, [
				'label'    => $icon->label(),
				'filePath' => $icon->filePath()
			]);
		}
	}
}
