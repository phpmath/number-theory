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
 * Euler's totient function.
 */
final class Totient
{
    /** @codeCoverageIgnore The constructor only prevents instantiation. */
    private function __construct()
    {
    }

    /**
     * Counts the integers in 1..n that are coprime to n.
     *
     * The number is factored first, see {@see Factorizer} for the practical limits.
     *
     * @param BigInteger $number The number, must be at least 1.
     *
     * @throws InvalidNumberException Thrown if the number is smaller than 1.
     */
    public static function of(BigInteger $number): BigInteger
    {
        return Factorizer::factorize($number)->totient();
    }
}
