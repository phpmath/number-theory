<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Exception;

use DomainException;

/**
 * Thrown when a system of congruences has no solution.
 */
final class UnsolvableCongruenceException extends DomainException implements NumberTheoryException
{
    /**
     * Creates the exception for an inconsistent system.
     */
    public static function inconsistent(): self
    {
        return new self('The system of congruences has no solution.');
    }
}
