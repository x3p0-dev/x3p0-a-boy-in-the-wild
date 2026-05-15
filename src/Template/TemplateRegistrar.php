<?php

/**
 * Template registrar.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Template;

use X3P0\ABoyInTheWild\Framework\Contracts\Bootable;

/**
 * Registers templates with WordPress.
 */
final class TemplateRegistrar implements Bootable
{
	/**
	 * @inheritDoc
	 */
	public function boot(): void
	{
		add_filter('default_template_types', $this->register(...));
	}

	/**
	 * Adds templates if WordPress hasn't defined them by default.
	 *
	 * @link https://developer.wordpress.org/reference/hooks/default_template_types/
	 */
	private function register(array $types): array
	{
		$types['front-page'] = [
			'title'       => _x('The Cover', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('The front page of the book. The first thing the reader sees.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['home'] = [
			'title'       => _x('The Field Notes', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays the chapter list when the front page is set to a static page.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['single-post'] = [
			'title'       => _x('Chapter', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays single chapters on your website unless a custom template has been applied to that chapter or a more specific template exists.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['single-post-sealed'] = [
			'title'        => _x('Sealed Chapter', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description'  => __('Displays the password (key) form for a sealed (password-protected) post.', 'x3p0-a-boy-in-the-wild')
		];

		$types['page'] = [
			'title'       => _x('Waymark', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays static waymarks such as the guestbook or introduction.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['archive'] = [
			'title'       => _x('The Trail', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays a collection of chapters grouped by era, arc, or other criteria.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['category'] = [
			'title'       => _x('Era', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays chapters from a specific era of the story.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['tag'] = [
			'title'       => _x('Arc', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays chapters belonging to a specific story arc.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['author'] = [
			'title'       => _x('The Narrator', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays chapters written by a specific narrator.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['date'] = [
			'title'       => _x('By Season', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays chapters from a specific time period.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['search'] = [
			'title'       => _x('The Search', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays results when a reader searches for something in the field notes.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['404'] = [
			'title'       => _x('Lost', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays when a reader follows a path that leads nowhere.', 'x3p0-a-boy-in-the-wild'),
		];

		$types['attachment'] = [
			'title'       => _x('Media Item', 'Template name', 'x3p0-a-boy-in-the-wild'),
			'description' => __('Displays a single item from the media archive — a sketch, a map, a photograph.', 'x3p0-a-boy-in-the-wild'),
		];

		return $types;
	}
}
