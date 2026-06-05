<?php

/**
 * Chapter factory.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Story\Chapter;

use WP_Post;
use X3P0\ABoyInTheWild\Story\Moment\MomentFactory;

/**
 * Reconstitutes Chapter aggregates from posts, knowing what a chapter is
 * composed of: the post, its moment on the story calendar, and its authored
 * designation. Moment construction is delegated to the MomentFactory; the
 * designation is read from post meta. Registered as a singleton; the only place
 * chapters are constructed.
 *
 * Holds no identity — each call builds a fresh Chapter. One-instance-per-post
 * is the ChapterRepository's concern, not the factory's.
 */
final class ChapterFactory
{
	public function __construct(
		private readonly MomentFactory $moments
	) {}

	/**
	 * Builds a chapter from a post.
	 */
	public function make(WP_Post $post): Chapter
	{
		return new Chapter(
			post:        $post,
			moment:      $this->moments->forPost($post),
			designation: $this->designationOf($post)
		);
	}

	/**
	 * Builds a designation from a post's authored meta.
	 */
	private function designationOf(WP_Post $post): ChapterDesignation
	{
		$type   = (string) get_post_meta($post->ID, ChapterMetaRegistrar::TYPE, true);
		$number = (int) get_post_meta($post->ID, ChapterMetaRegistrar::NUMBER, true);

		return new ChapterDesignation(
			type:   ChapterType::tryFrom($type) ?? ChapterType::Chapter,
			number: $number > 0 ? $number : null
		);
	}
}
