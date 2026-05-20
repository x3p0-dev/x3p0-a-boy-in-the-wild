<?php

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Support;

use DateTimeImmutable;
use DateTimeZone;
use NumberFormatter;
use WP_Post;

/**
 * Resolves a post's publication date to a story day (Day 1 onward) and
 * formats it in whichever style the caller needs.
 *
 * The epoch is shared with StoryYear via StoryEpoch, so the database query
 * runs at most once per request regardless of how many instances of either
 * class are created.
 *
 * Ordinal formatting requires the intl extension. When intl is unavailable,
 * ordinal() falls back to numeric().
 */
class StoryDay
{
	private function __construct(private readonly int $day) {}

	public static function fromPost(WP_Post $post): static
	{
		$zone = new DateTimeZone(wp_timezone_string());
		$date = DateTimeImmutable::createFromFormat(
			'Y-m-d H:i:s',
			$post->post_date,
			$zone
		);

		return static::fromDate($date ?: new DateTimeImmutable('now', $zone));
	}

	public static function fromCurrentPost(): ?static
	{
		$post = get_post();
		return $post instanceof WP_Post ? static::fromPost($post) : null;
	}

	public static function fromTimestamp(int $timestamp): static
	{
		$zone = new DateTimeZone(wp_timezone_string());
		$date = (new DateTimeImmutable('now', $zone))->setTimestamp($timestamp);

		return static::fromDate($date);
	}

	public static function fromDate(DateTimeImmutable $date): static
	{
		$epoch = StoryEpoch::get();
		$day   = 1;

		if ($epoch !== false && $date >= $epoch) {
			// diff()->days gives the total number of complete elapsed days.
			// Add 1 so the epoch date itself is Day 1.
			$day = max(1, $epoch->diff($date)->days + 1);
		}

		return new static($day);
	}

	public static function supportsRichFormats(): bool
	{
		return class_exists(NumberFormatter::class);
	}

	/**
	 * Returns the raw day number: 1, 2, 3 …
	 */
	public function number(): int
	{
		return $this->day;
	}

	/**
	 * "Day 1", "Day 31", "Day 4748".
	 * Always available.
	 */
	public function numeric(): string
	{
		return sprintf(
			// Translators: %d is the story day number.
			_x('Day %d', 'story day numeric', 'x3p0-a-boy-in-the-wild'),
			$this->day
		);
	}

	/**
	 * "Day 1st", "Day 31st", "Day 4748th".
	 * Falls back to numeric() when intl is unavailable.
	 */
	public function ordinal(): string
	{
		if (!self::supportsRichFormats()) {
			return $this->numeric();
		}

		$formatter = new NumberFormatter(get_locale(), NumberFormatter::ORDINAL);
		$result    = $formatter->format($this->day);

		if ($result === false) {
			return $this->numeric();
		}

		return sprintf(
			// Translators: %s is the story day as a locale-formatted ordinal (e.g. "31st"). */
			_x('%s day', 'story day ordinal', 'x3p0-a-boy-in-the-wild'),
			$result
		);
	}
}
