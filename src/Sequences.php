<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\NegativeArgumentException;
use PHPMath\NumberTheory\Internal\GmpBridge;

use function gmp_add;
use function gmp_init;
use function gmp_mul;
use function gmp_sub;

use const PHP_INT_SIZE;

/**
 * Fibonacci numbers and factorials.
 */
final class Sequences
{
    /** @codeCoverageIgnore The constructor only prevents instantiation. */
    private function __construct()
    {
    }

    /**
     * Returns the n-th Fibonacci number, with F(0) = 0 and F(1) = 1.
     *
     * Uses fast doubling, so it needs O(log n) multiplications.
     *
     * @param int $n The index, must not be negative.
     *
     * @throws NegativeArgumentException Thrown if n is negative.
     */
    public static function fibonacci(int $n): BigInteger
    {
        if ($n < 0) {
            throw NegativeArgumentException::forArgument('n', $n);
        }

        $a = gmp_init(0);
        $b = gmp_init(1);

        for ($bit = (PHP_INT_SIZE * 8) - 2; $bit >= 0; $bit--) {
            $doubled = gmp_mul($a, gmp_sub(gmp_mul($b, 2), $a));
            $next = gmp_add(gmp_mul($a, $a), gmp_mul($b, $b));

            if ((($n >> $bit) & 1) === 1) {
                $a = $next;
                $b = gmp_add($doubled, $next);
            } else {
                $a = $doubled;
                $b = $next;
            }
        }

        return GmpBridge::toBigInteger($a);
    }

    /**
     * Returns n!, with 0! = 1.
     *
     * @param int $n The number, must not be negative.
     *
     * @throws NegativeArgumentException Thrown if n is negative.
     */
    public static function factorial(int $n): BigInteger
    {
        if ($n < 0) {
            throw NegativeArgumentException::forArgument('n', $n);
        }

        return (new BigInteger($n))->factorial();
    }
}
