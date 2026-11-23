<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory;

use PHPMath\BigInteger\BigInteger;

/**
 * The result of the extended Euclidean algorithm.
 *
 * For the inputs a and b it holds that: a * x + b * y = gcd (Bezout's identity).
 */
final readonly class ExtendedGcd
{
    /**
     * Initializes a new result.
     *
     * @param BigInteger $gcd The non-negative greatest common divisor.
     * @param BigInteger $x   The Bezout coefficient of the first input.
     * @param BigInteger $y   The Bezout coefficient of the second input.
     */
    public function __construct(
        public BigInteger $gcd,
        public BigInteger $x,
        public BigInteger $y,
    ) {
    }

    /**
     * Checks that a * x + b * y equals the greatest common divisor.
     *
     * @param BigInteger $a The first input of the algorithm.
     * @param BigInteger $b The second input of the algorithm.
     */
    public function satisfiesBezout(BigInteger $a, BigInteger $b): bool
    {
        return $a->multiply($this->x)->add($b->multiply($this->y))->equals($this->gcd);
    }
}
