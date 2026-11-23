<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory;

use PHPMath\BigInteger\BigInteger;
use PHPMath\BigInteger\Exception\NotInvertibleException as BigIntegerNotInvertibleException;
use PHPMath\NumberTheory\Exception\InvalidModulusException;
use PHPMath\NumberTheory\Exception\NotInvertibleException;
use PHPMath\NumberTheory\Internal\GmpBridge;

use function gmp_powm;

/**
 * Modular exponentiation and modular inverses.
 */
final class ModularArithmetic
{
    /** @codeCoverageIgnore The constructor only prevents instantiation. */
    private function __construct()
    {
    }

    /**
     * Computes base^exponent mod modulus in the range 0 <= result < modulus.
     *
     * A negative exponent raises the modular inverse of the base to the absolute value of the exponent.
     * BigInteger has no modular exponentiation, so this uses GMP directly.
     *
     * @param BigInteger $base     The base.
     * @param BigInteger $exponent The exponent.
     * @param BigInteger $modulus  The modulus, must be positive.
     *
     * @throws InvalidModulusException Thrown if the modulus is not positive.
     * @throws NotInvertibleException Thrown if the exponent is negative and the base has no inverse.
     */
    public static function powMod(BigInteger $base, BigInteger $exponent, BigInteger $modulus): BigInteger
    {
        if (!$modulus->isPositive()) {
            throw InvalidModulusException::fromModulus($modulus->value());
        }

        if ($exponent->isNegative()) {
            $base = self::inverse($base, $modulus);
            $exponent = $exponent->negate();
        }

        return GmpBridge::toBigInteger(
            gmp_powm(GmpBridge::toGmp($base), GmpBridge::toGmp($exponent), GmpBridge::toGmp($modulus)),
        );
    }

    /**
     * Computes the multiplicative inverse of a value modulo the modulus.
     *
     * The result x satisfies value * x = 1 (mod modulus) with 0 <= x < modulus.
     * Modulo 1 every number is congruent to 0, so the result is 0 in that case.
     *
     * @param BigInteger $value   The value to invert.
     * @param BigInteger $modulus The modulus, must be positive.
     *
     * @throws InvalidModulusException Thrown if the modulus is not positive.
     * @throws NotInvertibleException Thrown if value and modulus are not coprime.
     */
    public static function inverse(BigInteger $value, BigInteger $modulus): BigInteger
    {
        if (!$modulus->isPositive()) {
            throw InvalidModulusException::fromModulus($modulus->value());
        }

        if ($modulus->equals(new BigInteger(1))) {
            return new BigInteger(0);
        }

        try {
            return $value->invert($modulus);
        } catch (BigIntegerNotInvertibleException) {
            throw NotInvertibleException::fromValues($value->value(), $modulus->value());
        }
    }
}
