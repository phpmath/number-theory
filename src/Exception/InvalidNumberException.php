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
 * Thrown when a number does not satisfy the requirements of an operation.
 */
final class InvalidNumberException extends InvalidArgumentException implements NumberTheoryException
{
    /**
     * Creates the exception with a description of the requirement that was violated.
     *
     * @param string $requirement What the number should have been, for example "a positive integer".
     * @param string $value       The decimal representation of the rejected number.
     */
    public static function expected(string $requirement, string $value): self
    {
        return new self(sprintf('Expected %s, got %s.', $requirement, $value));
    }
}
