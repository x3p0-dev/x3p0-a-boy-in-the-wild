<?php

/**
 * Chapter repository.
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
use X3P0\ABoyInTheWild\Story\StoryEpoch;

/**
 * Retrieves Chapter aggregates, hiding the WordPress persistence behind the
 * domain type. Read-only: it loads a chapter by ID — or reconstitutes one from
 * a post already in hand — and owns the sequence-position count. Moment
 * construction is delegated to the MomentFactory.
 *
 * Registered as a singleton, and chapters are kept in an identity map, so each
 * post yields a single Chapter instance per request (and so at most one
 * position count, which that chapter caches).
 */
final class ChapterRepository
{
	/**
	 * Identity map of resolved chapters keyed by post ID.
	 *
	 * @var array<int, Chapter>
	 */
	private array $chapters = [];

	public function __construct(
		private readonly MomentFactory $moments,
		private readonly StoryEpoch $epoch
	) {}

	/**
	 * Loads a chapter by post ID, or null when no such post exists.
	 */
	public function find(int $postId): ?Chapter
	{
		$post = get_post($postId);
		return $post instanceof WP_Post ? $this->forPost($post) : null;
	}

	/**
	 * Loads the first chapter — the story's origin post — or null when none
	 * exists. Shares the StoryEpoch lookup rather than querying again.
	 */
	public function first(): ?Chapter
	{
		$post = $this->epoch->post();

		return $post instanceof WP_Post ? $this->forPost($post) : null;
	}

	/**
	 * Reconstitutes a chapter from a post already in hand, returning the
	 * existing instance when one has already been built for that post.
	 */
	public function forPost(WP_Post $post): Chapter
	{
		return $this->chapters[$post->ID] ??= new Chapter(
			$post,
			$this->moments->forPost($post),
			fn (): int => $this->countPosition($post)
		);
	}

	/**
	 * Counts the post's position in its own status sequence: 1, 2, 3 …
	 *
	 * Each post status keeps a separate sequence — published chapters are
	 * numbered among published chapters, private among private — so the count
	 * is of same-status posts dated on or before this one. Caching is left to
	 * the chapter, which calls this at most once.
	 */
	private function countPosition(WP_Post $post): int
	{
		global $wpdb;

		$count = (int) $wpdb->get_var($wpdb->prepare(
			"SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'post' AND post_status = %s AND post_date <= %s",
			$post->post_status,
			$post->post_date
		));

		return max(1, $count);
	}
}
