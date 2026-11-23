<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory;

use GMP;
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Internal\GmpBridge;

use function gmp_gcdext;

/**
 * Divisibility and greatest common divisor helpers.
 *
 * {@see gcd()} and {@see lcm()} delegate to BigInteger, the other helpers add behaviour BigInteger does not have.
 */
final class Divisibility
{
    /** @codeCoverageIgnore The constructor only prevents instantiation. */
    private function __construct()
    {
    }

    /**
     * Checks whether the divisor divides the value without a remainder.
     *
     * Zero only divides zero.
     *
     * @param BigInteger $divisor The divisor.
     * @param BigInteger $value   The value to divide.
     */
    public static function divides(BigInteger $divisor, BigInteger $value): bool
    {
        if ($divisor->isZero()) {
            return $value->isZero();
        }

        return $value->divideRemainder($divisor)->isZero();
    }

    /**
     * Checks whether two numbers share no prime factor.
     *
     * @param BigInteger $a The first number.
     * @param BigInteger $b The second number.
     */
    public static function isCoprime(BigInteger $a, BigInteger $b): bool
    {
        return self::gcd($a, $b)->equals(new BigInteger(1));
    }

    /**
     * Returns the non-negative greatest common divisor.
     *
     * @param BigInteger $a The first number.
     * @param BigInteger $b The second number.
     */
    public static function gcd(BigInteger $a, BigInteger $b): BigInteger
    {
        return $a->greatestCommonDivisor($b);
    }

    /**
     * Returns the non-negative least common multiple.
     *
     * @param BigInteger $a The first number.
     * @param BigInteger $b The second number.
     */
    public static function lcm(BigInteger $a, BigInteger $b): BigInteger
    {
        return $a->leastCommonMultiple($b);
    }

    /**
     * Runs the extended Euclidean algorithm.
     *
     * @param BigInteger $a The first number.
     * @param BigInteger $b The second number.
     *
     * @return ExtendedGcd The gcd and coefficients x and y with a * x + b * y = gcd.
     */
    public static function extendedGcd(BigInteger $a, BigInteger $b): ExtendedGcd
    {
        /** @var array{g: GMP, s: GMP, t: GMP} $result */
        $result = gmp_gcdext(GmpBridge::toGmp($a), GmpBridge::toGmp($b));

        return new ExtendedGcd(
            GmpBridge::toBigInteger($result['g']),
            GmpBridge::toBigInteger($result['s']),
            GmpBridge::toBigInteger($result['t']),
        );
    }
}
