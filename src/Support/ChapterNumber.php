<?php

/**
 * Chapter number support class.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Support;

use WP_Post;

/**
 * Resolves a post's position in the published chapter sequence (Chapter 1
 * onward) and formats it in whichever style the caller needs.
 *
 * The count is derived at runtime by querying the number of published posts
 * with a date less than or equal to the current post's date. The result is
 * cached per post ID within a single request.
 */
class ChapterNumber
{
	/**
	 * Cached chapter numbers keyed by post ID.
	 *
	 * @var array<int, int>
	 */
	private static array $cache = [];

	private function __construct(private readonly int $number) {}

	public static function fromPost(WP_Post $post): static
	{
		if (isset(self::$cache[$post->ID])) {
			return new static(self::$cache[$post->ID]);
		}

		global $wpdb;

		$number = (int) $wpdb->get_var($wpdb->prepare(
			"SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = 'publish' AND post_date <= %s",
			$post->post_date
		));

		self::$cache[$post->ID] = max(1, $number);

		return new static(self::$cache[$post->ID]);
	}

	public static function fromPostId(int $postId): ?static
	{
		$post = get_post($postId);
		return $post instanceof WP_Post ? static::fromPost($post) : null;
	}

	/**
	 * Returns the raw chapter number: 1, 2, 3 …
	 */
	public function number(): int
	{
		return $this->number;
	}

	/**
	 * "Chapter 1", "Chapter 14", "Chapter 192".
	 */
	public function numeric(): string
	{
		return sprintf(
			// Translators: %d is the chapter number.
			_x('Chapter %d', 'chapter number numeric', 'x3p0-a-boy-in-the-wild'),
			$this->number
		);
	}

	/**
	 * "Chapter I", "Chapter XIV", "Chapter CXCII".
	 * Falls back to numeric() for values above 3,999 where standard Roman
	 * numeral notation becomes impractical.
	 */
	public function roman(): string
	{
		if ($this->number > 3999) {
			return $this->numeric();
		}

		return sprintf(
			// Translators: %s is the chapter number as a Roman numeral.
			_x('Chapter %s', 'chapter number roman', 'x3p0-a-boy-in-the-wild'),
			$this->toRoman($this->number)
		);
	}

	private function toRoman(int $n): string
	{
		if ($n < 1) {
			return '';
		}

		$numerals = [
			1000 => 'M',
			900  => 'CM',
			500  => 'D',
			400  => 'CD',
			100  => 'C',
			90   => 'XC',
			50   => 'L',
			40   => 'XL',
			10   => 'X',
			9    => 'IX',
			5    => 'V',
			4    => 'IV',
			1    => 'I',
		];

		$result = '';

		foreach ($numerals as $value => $numeral) {
			while ($n >= $value) {
				$result .= $numeral;
				$n      -= $value;
			}
		}

		return $result;
	}
}
