<?php

/**
 * Story service provider.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story;

use X3P0\ABoyInTheWild\Framework\Core\ServiceProvider;
use X3P0\ABoyInTheWild\Story\Calendar\Almanac;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterFactory;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterMetaRegistrar;
use X3P0\ABoyInTheWild\Story\Chapter\ChapterRepository;
use X3P0\ABoyInTheWild\Story\Moment\MomentFactory;
use X3P0\ABoyInTheWild\Story\Sky\LunarCycle;
use X3P0\ABoyInTheWild\Story\Sky\SolarCycle;
use X3P0\ABoyInTheWild\Story\Timeline\Epoch;

/**
 * Registers the Story domain services. The value objects (chapters, moments,
 * days, seasons …) are not bound — they are built on demand by the resolver.
 */
final class StoryServiceProvider extends ServiceProvider
{
	protected const SINGLETONS = [
		ChapterFactory::class,
		ChapterRepository::class,
		MomentFactory::class,
		Almanac::class,
		Epoch::class,
		LunarCycle::class,
		SolarCycle::class
	];

	protected const BOOTABLE = [
		ChapterMetaRegistrar::class
	];
}
