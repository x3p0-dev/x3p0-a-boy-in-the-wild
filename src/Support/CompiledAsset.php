<?php

/**
 * Compiled asset file.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Support;

use SplFileInfo;

/**
 * Represents a compiled theme asset: a built file (`.js` or `.css`) paired with
 * the `.asset.php` sidecar of dependency and version metadata emitted by the
 * build step. Extends {@see SplFileInfo} so the built file's filesystem metadata
 * is available alongside the theme URL and sidecar helpers that every enqueued
 * script and style needs. Centralizes the parent-theme resolution and the
 * sidecar read shared across the theme.
 */
final class CompiledAsset extends SplFileInfo
{
	/**
	 * Cached sidecar metadata, loaded on first access.
	 */
	private ?array $assetData = null;

	/**
	 * @param string $path Theme-relative path to the built file, e.g.
	 *                      `public/js/canvas/scene/motes.js`.
	 */
	public function __construct(private readonly string $path)
	{
		parent::__construct(get_parent_theme_file_path($path));
	}

	/**
	 * Creates an instance from a discovered file, deriving its theme-relative
	 * path from the absolute pathname.
	 */
	public static function fromFile(SplFileInfo $file): self
	{
		return new self(ltrim(
			substr($file->getPathname(), strlen(get_parent_theme_file_path())),
			'/'
		));
	}

	/**
	 * Returns the public URL to the built file.
	 */
	public function fileUrl(): string
	{
		return get_parent_theme_file_uri($this->path);
	}

	/**
	 * Returns the absolute filesystem path to the built file.
	 */
	public function filePath(): string
	{
		return $this->getPathname();
	}

	/**
	 * Whether the `.asset.php` sidecar exists.
	 */
	public function hasAssetFile(): bool
	{
		return file_exists($this->assetFilePath());
	}

	/**
	 * Returns the full sidecar metadata array.
	 */
	public function assetData(): array
	{
		return $this->assetData ??= include $this->assetFilePath();
	}

	/**
	 * Returns the asset's registered dependencies.
	 *
	 * @return array<string>
	 */
	public function dependencies(): array
	{
		return $this->assetData()['dependencies'] ?? [];
	}

	/**
	 * Returns the asset's cache-busting version hash.
	 */
	public function version(): string
	{
		return $this->assetData()['version'] ?? '';
	}

	/**
	 * Returns the absolute path to the `.asset.php` sidecar (the built file's
	 * name with its extension swapped for `.asset.php`).
	 */
	private function assetFilePath(): string
	{
		return sprintf(
			'%s/%s.asset.php',
			$this->getPath(),
			$this->getBasename('.' . $this->getExtension())
		);
	}
}
