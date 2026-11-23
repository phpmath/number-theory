<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Exception;

use InvalidArgumentException;

/**
 * Thrown when a system of congruences contains no congruences.
 */
final class EmptyCongruenceSystemException extends InvalidArgumentException implements NumberTheoryException
{
    /**
     * Creates the exception.
     */
    public static function create(): self
    {
        return new self('At least one congruence is required.');
    }
}
