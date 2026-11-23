<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory;

use PHPMath\NumberTheory\Exception\LimitTooLargeException;
use PHPMath\NumberTheory\Exception\NegativeArgumentException;

use function str_repeat;

/**
 * Generates prime numbers with the sieve of Eratosthenes.
 */
final class PrimeSieve
{
    /**
     * The largest limit that {@see primesUpTo()} accepts. A sieve up to this limit fits in the default PHP memory
     * limit of 128 MB (it peaks at about 38 MB).
     */
    public const int MAX_LIMIT = 10_000_000;

    /** @codeCoverageIgnore The constructor only prevents instantiation. */
    private function __construct()
    {
    }

    /**
     * Returns all primes less than or equal to the limit in ascending order.
     *
     * The sieve needs about one byte per number up to the limit, plus the memory of the returned list.
     *
     * @param int $limit The inclusive upper bound.
     *
     * @return list<int> The primes up to and including the limit.
     *
     * @throws NegativeArgumentException Thrown if the limit is negative.
     * @throws LimitTooLargeException Thrown if the limit is greater than {@see MAX_LIMIT}.
     */
    public static function primesUpTo(int $limit): array
    {
        if ($limit < 0) {
            throw NegativeArgumentException::forArgument('limit', $limit);
        }

        if ($limit > self::MAX_LIMIT) {
            throw LimitTooLargeException::exceeds($limit, self::MAX_LIMIT);
        }

        if ($limit < 2) {
            return [];
        }

        $isPrime = str_repeat("\x01", $limit + 1);

        for ($i = 2; $i * $i <= $limit; $i++) {
            if ($isPrime[$i] !== "\x01") {
                continue;
            }

            for ($j = $i * $i; $j <= $limit; $j += $i) {
                $isPrime[$j] = "\x00";
            }
        }

        $primes = [];

        for ($i = 2; $i <= $limit; $i++) {
            if ($isPrime[$i] !== "\x01") {
                continue;
            }

            $primes[] = $i;
        }

        return $primes;
    }
}
