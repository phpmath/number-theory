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
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\Internal\GmpBridge;

use function gmp_abs;
use function gmp_add;
use function gmp_cmp;
use function gmp_div_q;
use function gmp_gcd;
use function gmp_init;
use function gmp_mod;
use function gmp_mul;
use function gmp_perfect_square;
use function gmp_sqrt;
use function gmp_strval;
use function gmp_sub;

/**
 * Splits integers into their prime factors.
 *
 * Small prime factors are removed by trial division. What remains is split with Pollard's rho algorithm, after a
 * primality test ({@see Primality::isPrime()}) has shown that it is not prime itself.
 *
 * Trial division is fast, but Pollard's rho needs roughly sqrt(p) steps for the second largest prime factor p. The
 * running time grows about ten times for every two extra digits in the factors. As a rough guide, a product of two
 * close primes of 6 digits each takes about 0.01 seconds, of 10 digits each 0.1 to 0.4 seconds and of 12 digits each
 * 1 to 3 seconds. Two primes of 20 digits each would take hours. There is no time limit.
 */
final class Factorizer
{
    /**
     * Trial division is done with all primes up to and including this bound.
     */
    private const int TRIAL_DIVISION_LIMIT = 10_000;

    /** @codeCoverageIgnore The constructor only prevents instantiation. */
    private function __construct()
    {
    }

    /**
     * Computes the prime factorization of a positive integer.
     *
     * @param BigInteger $number The number to factor, must be at least 1.
     *
     * @throws InvalidNumberException Thrown if the number is smaller than 1.
     */
    public static function factorize(BigInteger $number): PrimeFactorization
    {
        if (!$number->isPositive()) {
            throw InvalidNumberException::expected('a positive integer', $number->value());
        }

        $remaining = GmpBridge::toGmp($number);
        $exponents = [];

        foreach (PrimeSieve::primesUpTo(self::TRIAL_DIVISION_LIMIT) as $prime) {
            if (gmp_cmp($remaining, $prime * $prime) < 0) {
                break;
            }

            while (gmp_cmp(gmp_mod($remaining, $prime), 0) === 0) {
                $remaining = gmp_div_q($remaining, $prime);
                self::count($exponents, gmp_strval($prime));
            }
        }

        if (gmp_cmp($remaining, 1) > 0) {
            self::split($remaining, $exponents);
        }

        return new PrimeFactorization($exponents);
    }

    /**
     * Recursively splits a number greater than 1 that has no prime factors below the trial division limit.
     *
     * @param GMP $number    The number to split.
     * @param array<int|string, int> $exponents The exponents found so far, by reference.
     */
    private static function split(GMP $number, array &$exponents): void
    {
        if (Primality::isPrime(GmpBridge::toBigInteger($number))) {
            self::count($exponents, gmp_strval($number));

            return;
        }

        if (gmp_perfect_square($number)) {
            $root = gmp_sqrt($number);
            self::split($root, $exponents);
            self::split($root, $exponents);

            return;
        }

        $factor = self::findFactor($number);

        self::split($factor, $exponents);
        self::split(gmp_div_q($number, $factor), $exponents);
    }

    /**
     * Finds a non-trivial factor of an odd composite number with Pollard's rho algorithm.
     *
     * @param GMP $number An odd composite number that is not a perfect square.
     */
    private static function findFactor(GMP $number): GMP
    {
        for ($c = 1;; $c++) {
            $x = gmp_init(2);
            $y = gmp_init(2);
            $divisor = gmp_init(1);

            while (gmp_cmp($divisor, 1) === 0) {
                $x = gmp_mod(gmp_add(gmp_mul($x, $x), $c), $number);
                $y = gmp_mod(gmp_add(gmp_mul($y, $y), $c), $number);
                $y = gmp_mod(gmp_add(gmp_mul($y, $y), $c), $number);
                $divisor = gmp_gcd(gmp_abs(gmp_sub($x, $y)), $number);
            }

            if (gmp_cmp($divisor, $number) !== 0) {
                return $divisor;
            }
        }
    }

    /**
     * Adds one to the exponent of a prime.
     *
     * @param array<int|string, int> $exponents The exponents, by reference.
     * @param string $prime     The decimal representation of the prime.
     */
    private static function count(array &$exponents, string $prime): void
    {
        $exponents[$prime] = ($exponents[$prime] ?? 0) + 1;
    }
}
