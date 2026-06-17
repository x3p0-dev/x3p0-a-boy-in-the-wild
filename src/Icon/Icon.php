<?php

/**
 * Icon enum.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Icon;

/**
 * Enum of icons registered with and used throughout the theme.
 */
enum Icon: string
{
	case BirdHorizon = 'x3p0/bird-horizon';
	case Compass     = 'x3p0/compass';
	case Crosshair   = 'x3p0/crosshair';
	case Draw        = 'x3p0/draw';
	case Forest      = 'x3p0/forest';
	case Route       = 'x3p0/route';
	case SealedKey   = 'x3p0/sealed-key';
	case Sundial     = 'x3p0/sundial';
	case SunPath     = 'x3p0/sun-path';

	/**
	 * Namespace prefix for all registered icon names.
	 */
	private const NAMESPACE = 'x3p0';

	/**
	 * Path to the icons folder relative to the theme root.
	 */
	private const ICONS_PATH = 'public/media/svg/icon';

	/**
	 * Returns the icon's translated label.
	 */
	public function label(): string
	{
		return match ($this) {
			self::BirdHorizon => __('Bird Horizon', 'x3p0-a-boy-in-the-wild'),
			self::Compass     => __('Compass',      'x3p0-a-boy-in-the-wild'),
			self::Crosshair   => __('Crosshair',    'x3p0-a-boy-in-the-wild'),
			self::Draw        => __('Draw',         'x3p0-a-boy-in-the-wild'),
			self::Forest      => __('Forest',       'x3p0-a-boy-in-the-wild'),
			self::Route       => __('Route',        'x3p0-a-boy-in-the-wild'),
			self::SealedKey   => __('Sealed Key',   'x3p0-a-boy-in-the-wild'),
			self::Sundial     => __('Sundial',      'x3p0-a-boy-in-the-wild'),
			self::SunPath     => __('Sun Path',     'x3p0-a-boy-in-the-wild')
		};
	}

	/**
	 * Returns the icon's slug, derived from its value by stripping the
	 * namespace prefix.
	 */
	public function slug(): string
	{
		return substr($this->value, strlen(self::NAMESPACE . '/'));
	}

	/**
	 * Returns the absolute file path to the icon's SVG file.
	 */
	public function filePath(): string
	{
		return get_parent_theme_file_path(self::ICONS_PATH . '/' . $this->slug() . '.svg');
	}
}
