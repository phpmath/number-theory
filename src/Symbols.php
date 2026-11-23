<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidNumberException;

/**
 * The Jacobi and Legendre symbols.
 *
 * BigInteger already computes both, but with undefined results for invalid denominators. These wrappers validate
 * the denominator first.
 */
final class Symbols
{
    /** @codeCoverageIgnore The constructor only prevents instantiation. */
    private function __construct()
    {
    }

    /**
     * Computes the Jacobi symbol (a / n).
     *
     * @param BigInteger $a The numerator, any integer.
     * @param BigInteger $n The denominator, must be a positive odd integer.
     *
     * @return int -1, 0 or 1.
     *
     * @throws InvalidNumberException Thrown if n is not a positive odd integer.
     */
    public static function jacobi(BigInteger $a, BigInteger $n): int
    {
        if (!$n->isPositive() || $n->divideRemainder(new BigInteger(2))->isZero()) {
            throw InvalidNumberException::expected('a positive odd integer', $n->value());
        }

        return $a->jacobi($n);
    }

    /**
     * Computes the Legendre symbol (a / p): 1 if a is a non-zero square modulo p, -1 if it is a non-square and 0 if p
     * divides a.
     *
     * The denominator is validated with {@see Primality::isPrime()}, which is exact below
     * {@see Primality::DETERMINISTIC_BOUND} and probabilistic from there on.
     *
     * @param BigInteger $a The numerator, any integer.
     * @param BigInteger $p The denominator, must be an odd prime.
     *
     * @return int -1, 0 or 1.
     *
     * @throws InvalidNumberException Thrown if p is not an odd prime.
     */
    public static function legendre(BigInteger $a, BigInteger $p): int
    {
        if ($p->cmp(new BigInteger(2)) <= 0 || !Primality::isPrime($p)) {
            throw InvalidNumberException::expected('an odd prime', $p->value());
        }

        return $a->legendre($p);
    }
}
