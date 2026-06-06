<?php

/**
 * Moment factory.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Moment;

use DateTimeImmutable;
use DateTimeZone;
use Exception;
use WP_Post;
use X3P0\ABoyInTheWild\Story\{
	StoryAlmanac,
	StoryEpoch,
	StoryLunarCycle,
	StorySolarCycle
};

/**
 * Builds moments on the story's calendar. Callers describe the point they want
 * — a post's publication date, an arbitrary date, or "now" — and the factory
 * wires in the Epoch and Almanac each moment reads from. Registered as a
 * singleton; the only place moments are constructed.
 */
final class MomentFactory
{
	public function __construct(
		private readonly StoryEpoch $epoch,
		private readonly StoryAlmanac $almanac,
		private readonly StoryLunarCycle $lunar,
		private readonly StorySolarCycle $solar
	) {}

	/**
	 * A moment at the given date.
	 */
	public function make(DateTimeImmutable $date): Moment
	{
		return new Moment(
			date:    $date,
			epoch:   $this->epoch,
			almanac: $this->almanac,
			lunar:   $this->lunar,
			solar:   $this->solar
		);
	}

	/**
	 * A moment at a post's publication date.
	 *
	 * @throws Exception
	 */
	public function forPost(WP_Post $post): Moment
	{
		$zone = new DateTimeZone(wp_timezone_string());
		$date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $post->post_date, $zone);

		return $this->make($date ?: new DateTimeImmutable('now', $zone));
	}

	/**
	 * A moment at the current instant.
	 *
	 * @throws Exception
	 */
	public function now(): Moment
	{
		return $this->make(new DateTimeImmutable('now', new DateTimeZone(wp_timezone_string())));
	}
}
