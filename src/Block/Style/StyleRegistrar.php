<?php

/**
 * Block style variation registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Style;

use WP_Block_Styles_Registry;
use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Registers/unregisters block style variations.
 */
final class StyleRegistrar implements Bootable
{
	/**
	 * Core block styles to unregister that are not possible to unregister
	 * via `unregister_block_style()` due to being registered via JS.
	 *
	 * @todo Type hint with PHP 8.3+ requirement.
	 */
	private const UNREGISTER_STYLES = [
		'core/button'       => [ 'fill', 'outline' ],
		'core/quote'        => [ 'plain' ],
		'core/separator'    => [ 'dots', 'wide' ],
		'core/social-links' => [ 'pill-shape' ],
		'core/tag-cloud'    => [ 'outline' ]
	];

	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_filter('block_type_metadata', $this->unregisterCoreStyles(...));
	}

	/**
	 * Because Core block styles are registered via JavaScript, you cannot
	 * unregister them via `unregister_block_style()`. You can unregister
	 * using JavaScript or by filtering the block type's metadata, which
	 * we're doing here.
	 *
	 * @link https://github.com/WordPress/gutenberg/issues/25330
	 */
	private function unregisterCoreStyles(array $metadata): array
	{
		if (
			! isset(self::UNREGISTER_STYLES[$metadata['name']])
			|| ! isset($metadata['styles'])
		) {
			return $metadata;
		}

		$remove = self::UNREGISTER_STYLES[$metadata['name']];

		$metadata['styles'] = array_values(array_filter(
			$metadata['styles'],
			fn($style) => ! in_array($style['name'], $remove, true)
		));

		return $metadata;
	}
}
