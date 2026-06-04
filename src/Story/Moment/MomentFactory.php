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
use WP_Post;
use X3P0\ABoyInTheWild\Story\StoryAlmanac;
use X3P0\ABoyInTheWild\Story\StoryEpoch;

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
		private readonly StoryAlmanac $almanac
	) {}

	/**
	 * A moment at the given date.
	 */
	public function forDate(DateTimeImmutable $date): Moment
	{
		return new Moment($date, $this->epoch, $this->almanac);
	}

	/**
	 * A moment at a post's publication date.
	 */
	public function forPost(WP_Post $post): Moment
	{
		$zone = new DateTimeZone(wp_timezone_string());
		$date = DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $post->post_date, $zone);

		return $this->forDate($date ?: new DateTimeImmutable('now', $zone));
	}

	/**
	 * A moment at the current instant.
	 */
	public function now(): Moment
	{
		return $this->forDate(new DateTimeImmutable('now', new DateTimeZone(wp_timezone_string())));
	}
}
