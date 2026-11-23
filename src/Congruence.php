<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidModulusException;

/**
 * A congruence: x is congruent to remainder modulo modulus.
 *
 * The remainder is normalized into the range 0 <= remainder < modulus.
 */
final readonly class Congruence
{
    /**
     * The normalized remainder.
     */
    public BigInteger $remainder;

    /**
     * Initializes a new congruence.
     *
     * @param BigInteger $remainder The remainder, any integer is accepted and normalized.
     * @param BigInteger $modulus   The modulus, must be positive.
     *
     * @throws InvalidModulusException Thrown if the modulus is not positive.
     */
    public function __construct(
        BigInteger $remainder,
        public BigInteger $modulus,
    ) {
        if (!$modulus->isPositive()) {
            throw InvalidModulusException::fromModulus($modulus->value());
        }

        $this->remainder = $remainder->mod($modulus);
    }

    /**
     * Checks whether a number satisfies this congruence.
     *
     * @param BigInteger $value The number to test.
     */
    public function isSatisfiedBy(BigInteger $value): bool
    {
        return $value->mod($this->modulus)->equals($this->remainder);
    }

    /**
     * Returns the congruence in textual form, for example "x = 2 (mod 3)".
     */
    public function __toString(): string
    {
        return 'x = ' . $this->remainder->value() . ' (mod ' . $this->modulus->value() . ')';
    }
}
