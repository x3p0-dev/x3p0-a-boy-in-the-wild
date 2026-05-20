<?php
// src/Support/StoryYear.php

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Support;

use DateTimeImmutable;
use DateTimeZone;
use NumberFormatter;
use WP_Post;

/**
 * Resolves a post's publication date to a story year (Year 1 onward) and
 * formats it in whichever style the caller needs.
 *
 * The epoch is shared with StoryDay via StoryEpoch, so the database query
 * runs at most once per request regardless of how many instances of either
 * class are created.
 *
 * Ordinal and word-form methods require the intl extension. When intl is
 * unavailable they fall back to the numeric form. Whether intl is present can
 * be checked via supportsRichFormats() before calling those methods.
 */
class StoryYear
{
	private function __construct(private readonly int $year) {}

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
		$year  = 1;

		if ($epoch !== false && $date >= $epoch) {
			$year = max(1, $epoch->diff($date)->y + 1);
		}

		return new static($year);
	}

	/**
	 * Whether ordinal() and word() are available.
	 * Both require the intl extension (recommended but not required by WordPress).
	 */
	public static function supportsRichFormats(): bool
	{
		return class_exists(NumberFormatter::class);
	}

	/**
	 * Returns the raw year number: 1, 2, 3 …
	 */
	public function number(): int
	{
		return $this->year;
	}

	/**
	 * "Year 1", "Year 14", "Year 30".
	 * Always available.
	 */
	public function numeric(): string
	{
		return sprintf(
			// Translators: %d is the story year number.
			_x('Year %d', 'story year numeric', 'x3p0-a-boy-in-the-wild'),
			$this->year
		);
	}

	/**
	 * "1st Year", "14th Year", "21st Year".
	 * Falls back to numeric() when intl is unavailable.
	 */
	public function ordinal(): string
	{
		if (! self::supportsRichFormats()) {
			return $this->numeric();
		}

		$formatter = new NumberFormatter(get_locale(), NumberFormatter::ORDINAL);
		$result    = $formatter->format($this->year);

		if ($result === false) {
			return $this->numeric();
		}

		return sprintf(
			// Translators: %s is the story year as a locale-formatted ordinal (e.g. "14th").
			_x('%s Year', 'story year ordinal', 'x3p0-a-boy-in-the-wild'),
			$result
		);
	}

	/**
	 * "first year", "fourteenth year", "twenty-first year".
	 * Falls back to numeric() when intl is unavailable.
	 *
	 * The "@numbers=ordinal" locale extension requests ICU's ordinal spellout
	 * ruleset where available. ICU falls back to cardinal spelling gracefully
	 * when the ruleset is absent for a given locale.
	 */
	public function word(): string
	{
		if (! self::supportsRichFormats()) {
			return $this->numeric();
		}

		$formatter = new NumberFormatter(
			get_locale() . '@numbers=ordinal',
			NumberFormatter::SPELLOUT
		);
		$result = $formatter->format($this->year);

		if ($result === false) {
			return $this->numeric();
		}

		return ucwords(sprintf(
			// Translators: %s is the story year spelled out as an ordinal word (e.g. "fourteenth").
			_x('%s year', 'story year word', 'x3p0-a-boy-in-the-wild'),
			$result
		));
	}

	/**
	 * "The first year", "The fourteenth year" — dateline register.
	 * Falls back to numeric() when intl is unavailable.
	 */
	public function withArticle(): string
	{
		if (! self::supportsRichFormats()) {
			return $this->numeric();
		}

		$formatter = new NumberFormatter(
			get_locale() . '@numbers=ordinal',
			NumberFormatter::SPELLOUT
		);
		$result = $formatter->format($this->year);

		if ($result === false) {
			return $this->numeric();
		}

		return sprintf(
			// Translators: %s is the story year spelled out as an ordinal word (e.g. "fourteenth").
			_x('The %s year', 'story year with article', 'x3p0-a-boy-in-the-wild'),
			$result
		);
	}
}
