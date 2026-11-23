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
 * Thrown when a modulus is not a positive integer.
 */
final class InvalidModulusException extends InvalidArgumentException implements NumberTheoryException
{
    /**
     * Creates the exception for the given modulus.
     *
     * @param string $modulus The decimal representation of the rejected modulus.
     */
    public static function fromModulus(string $modulus): self
    {
        return new self(sprintf('The modulus must be a positive integer, got %s.', $modulus));
    }
}
