<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Exception;

use DomainException;

use function sprintf;

/**
 * Thrown when a number has no multiplicative inverse for the given modulus.
 */
final class NotInvertibleException extends DomainException implements NumberTheoryException
{
    /**
     * Creates the exception for the given value and modulus.
     *
     * @param string $value   The decimal representation of the value.
     * @param string $modulus The decimal representation of the modulus.
     */
    public static function fromValues(string $value, string $modulus): self
    {
        return new self(sprintf('%s has no inverse modulo %s because they are not coprime.', $value, $modulus));
    }
}
