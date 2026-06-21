<?php

/**
 * Undefined block target exception.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block;

use LogicException;

/**
 * Thrown when a block handler — a render filter or settings modifier — does not
 * declare the `#[ForBlock]` attribute, leaving the block type it targets
 * undefined. Extends `LogicException` because a handler with no target is a
 * wiring mistake in the code, not a recoverable runtime condition.
 */
class UndefinedBlockTargetException extends LogicException
{
}
