<?php

/**
 * Undefined binding name exception.
 *
 * @author    Justin Tadlock <justintadlock@gmail.com>
 * @copyright Copyright (c) 2026, Justin Tadlock
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GPL-3.0-or-later
 * @link      https://github.com/x3p0-dev/x3p0-a-boy-in-the-wild
 */

declare(strict_types=1);

namespace X3P0\ABoyInTheWild\Block\Binding;

use LogicException;

/**
 * Thrown when a block binding source does not define its `NAME` constant,
 * leaving it without the identifier required to register with the Block
 * Bindings API. Extends `LogicException` because a source with no name is a
 * coding mistake, not a recoverable runtime condition.
 */
class UndefinedBindingNameException extends LogicException
{
}
