<?php

/**
 * Audio service.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2023-2025, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Audio;

use WP_HTML_Tag_Processor;

/**
 * Primary entry point for audio functionality.
 *
 * Provides access to audio resolution and interactivity features.
 * Use this service to check the current audio, determine if switching
 * is available, and enable interactive audio switching.
 */
final class AudioService
{
	/**
	 * Sets up the initial object state.
	 */
	public function __construct(
		private readonly AudioResolver $resolver,
		private readonly AudioInteractivity $interactivity
	) {}

	/**
	 * Returns the resolver for checking switchability, current scheme, etc.
	 */
	public function resolver(): AudioResolver
	{
		return $this->resolver;
	}

	public function interactivity(): AudioInteractivity
	{
		return $this->interactivity;
	}
}
