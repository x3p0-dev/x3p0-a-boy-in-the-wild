<?php

/**
 * Block target attribute.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block;

use Attribute;
use ReflectionClass;
use ReflectionException;

/**
 * Declares the block type a handler targets. Render filters and settings
 * modifiers alike carry this attribute; their subscriber/dispatcher reads it to
 * wire each handler to the correct block:
 *
 *     #[ForBlock('core/group')]
 *     final class Group extends SettingsModifier {}
 */
#[Attribute(Attribute::TARGET_CLASS)]
final class ForBlock
{
	/**
	 * Sets up the object state.
	 *
	 * @param string $name The block type (e.g., 'core/group').
	 */
	public function __construct(public readonly string $name)
	{}

	/**
	 * Reads the target block from a handler class string or instance,
	 * throwing when the handler fails to declare the attribute.
	 *
	 * @throws ReflectionException
	 */
	public static function of(string|object $handler): string
	{
		$attributes = (new ReflectionClass($handler))->getAttributes(self::class);

		if (! $attributes) {
			throw new UndefinedBlockTargetException(sprintf(
				// Translators: 1: PHP classname, 2: PHP attribute name.
				__('%1$s must declare the %2$s attribute', 'x3p0-a-boy-in-the-wild'),
				is_object($handler) ? $handler::class : $handler,
				self::class
			));
		}

		/** @var ForBlock $instance */
		$instance = $attributes[0]->newInstance();

		return $instance->name;
	}
}
