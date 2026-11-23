<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Exception;

use InvalidArgumentException;

use function sprintf;

/**
 * Thrown when an argument must be zero or greater, but a negative value was given.
 */
final class NegativeArgumentException extends InvalidArgumentException implements NumberTheoryException
{
    /**
     * Creates the exception for the given argument.
     *
     * @param string $name  The name of the argument.
     * @param int $value The rejected value.
     */
    public static function forArgument(string $name, int $value): self
    {
        return new self(sprintf('The argument "%s" must not be negative, got %d.', $name, $value));
    }
}
