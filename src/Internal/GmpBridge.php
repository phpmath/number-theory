<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Internal;

use GMP;
use PHPMath\BigInteger\BigInteger;

use function gmp_init;
use function gmp_strval;

/**
 * Converts between BigInteger and GMP for the algorithms that need raw GMP speed.
 *
 * BigInteger does not expose its GMP handle, so values travel as decimal strings.
 *
 * @internal
 */
final class GmpBridge
{
    /** @codeCoverageIgnore The constructor only prevents instantiation. */
    private function __construct()
    {
    }

    /**
     * Converts a BigInteger to a GMP number.
     *
     * @param BigInteger $value The value to convert.
     */
    public static function toGmp(BigInteger $value): GMP
    {
        return gmp_init($value->value());
    }

    /**
     * Converts a GMP number to a BigInteger.
     *
     * @param GMP $value The value to convert.
     */
    public static function toBigInteger(GMP $value): BigInteger
    {
        return new BigInteger(gmp_strval($value));
    }
}
