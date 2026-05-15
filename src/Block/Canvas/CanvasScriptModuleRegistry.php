<?php

/**
 * Canvas script module registry.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Canvas;

/**
 * Stores canvas script module slugs by type and derives all enqueue data from
 * them. The type maps to the CSS class modifier (e.g., `bg`, `fg`, `game`),
 * and the slug maps to the filename and is used to build the handle and src.
 */
final class CanvasScriptModuleRegistry
{
	private const CSS_PREFIX    = 'x3p0-canvas';
	private const HANDLE_PREFIX = 'x3p0/canvas';
	private const SRC_PREFIX    = 'public/js/canvas';

	/**
	 * Stores slugs grouped by canvas type.
	 *
	 * @var array<string, string[]>
	 */
	private array $modules = [];

	/**
	 * Adds a canvas script module by type and slug.
	 */
	public function add(string $type, string $slug): void
	{
		$this->modules[$type][] = $slug;
	}

	/**
	 * Removes a canvas script module by type and slug.
	 */
	public function remove(string $type, string $slug): void
	{
		$this->modules[$type] = array_filter(
			$this->modules[$type] ?? [],
			fn($s) => $s !== $slug
		);
	}

	/**
	 * Checks if a canvas script module is registered.
	 */
	public function has(string $type, string $slug): bool
	{
		return in_array($slug, $this->modules[$type] ?? [], true);
	}

	/**
	 * Yields all registered modules with their derived CSS class, handle,
	 * and src path.
	 *
	 * @return iterable<string, array{handle: string, src: string}>
	 */
	public function all(): iterable
	{
		foreach ($this->modules as $type => $slugs) {
			foreach ($slugs as $slug) {
				yield self::CSS_PREFIX . "-{$type}--{$slug}" => [
					'handle' => self::HANDLE_PREFIX . "-{$type}-{$slug}",
					'src'    => self::SRC_PREFIX    . "/{$slug}.js",
				];
			}
		}
	}
}
