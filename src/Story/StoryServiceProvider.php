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
use X3P0\ABoyInTheWild\Story\Chapter\ChapterRepository;
use X3P0\ABoyInTheWild\Story\Moment\MomentFactory;

/**
 * Registers the Story domain services. The value objects (chapters, moments,
 * days, seasons …) are not bound — they are built on demand by the resolver.
 */
final class StoryServiceProvider extends ServiceProvider
{
	protected const SINGLETONS = [
		ChapterRepository::class,
		MomentFactory::class,
		StoryAlmanac::class,
		StoryEpoch::class
	];
}
