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

use function count;
use function gmp_cmp;
use function gmp_div_q;
use function gmp_mod;
use function gmp_mul;
use function gmp_pow;
use function gmp_powm;
use function gmp_scan1;
use function gmp_sub;

/**
 * Primality testing and prime search.
 *
 * {@see isPrime()} is a Miller-Rabin test:
 *
 * - Below {@see DETERMINISTIC_BOUND} the first 13 primes are used as witnesses. This is proven to be exact, the
 *   answer is never wrong.
 * - From that bound on the first 20 primes are used as witnesses. The answer is then probabilistic: composites are
 *   rejected, but a composite could in theory be reported as prime. For numbers that are not specially crafted to
 *   fool the test this does not happen in practice. Use {@see isExact()} to find out which case applies.
 */
final class Primality
{
    /**
     * Below this number (exclusive) the test with the first 13 primes as witnesses is proven to be exact.
     */
    public const string DETERMINISTIC_BOUND = '3317044064679887385961981';

    /**
     * Witnesses used for the test.
     */
    private const array WITNESSES = [2, 3, 5, 7, 11, 13, 17, 19, 23, 29, 31, 37, 41, 43, 47, 53, 59, 61, 67, 71];

    /**
     * The number of witnesses that is sufficient below the deterministic bound.
     */
    private const int DETERMINISTIC_WITNESS_COUNT = 13;

    /** @codeCoverageIgnore The constructor only prevents instantiation. */
    private function __construct()
    {
    }

    /**
     * Checks whether a number is prime. Numbers below 2 are not prime.
     *
     * The result is exact below {@see DETERMINISTIC_BOUND} and probabilistic beyond it, see the class description.
     *
     * @param BigInteger $number The number to test.
     */
    public static function isPrime(BigInteger $number): bool
    {
        if ($number->cmp(new BigInteger(2)) < 0) {
            return false;
        }

        $n = GmpBridge::toGmp($number);
        $count = self::isExact($number) ? self::DETERMINISTIC_WITNESS_COUNT : count(self::WITNESSES);

        for ($i = 0; $i < $count; $i++) {
            $witness = self::WITNESSES[$i];

            if (gmp_cmp($n, $witness) === 0) {
                return true;
            }

            if (gmp_cmp(gmp_mod($n, $witness), 0) === 0) {
                return false;
            }
        }

        $nMinusOne = gmp_sub($n, 1);
        $shifts = gmp_scan1($nMinusOne, 0);
        $odd = gmp_div_q($nMinusOne, gmp_pow(2, $shifts));

        for ($i = 0; $i < $count; $i++) {
            if (!self::passesWitness($n, $nMinusOne, $odd, $shifts, self::WITNESSES[$i])) {
                return false;
            }
        }

        return true;
    }

    /**
     * Tells whether {@see isPrime()} gives a proven answer for this number.
     *
     * @param BigInteger $number The number that is tested.
     */
    public static function isExact(BigInteger $number): bool
    {
        return $number->cmp(new BigInteger(self::DETERMINISTIC_BOUND)) < 0;
    }

    /**
     * Returns the smallest prime that is strictly greater than the number.
     *
     * @param BigInteger $number The lower bound (exclusive).
     */
    public static function nextPrime(BigInteger $number): BigInteger
    {
        if ($number->cmp(new BigInteger(2)) < 0) {
            return new BigInteger(2);
        }

        $one = new BigInteger(1);
        $two = new BigInteger(2);
        $candidate = $number->add($one);

        if (!self::isOdd($candidate)) {
            $candidate = $candidate->add($one);
        }

        while (!self::isPrime($candidate)) {
            $candidate = $candidate->add($two);
        }

        return $candidate;
    }

    /**
     * Returns the largest prime that is strictly smaller than the number.
     *
     * @param BigInteger $number The upper bound (exclusive), must be greater than 2.
     *
     * @throws InvalidNumberException Thrown if there is no smaller prime.
     */
    public static function previousPrime(BigInteger $number): BigInteger
    {
        $two = new BigInteger(2);

        if ($number->cmp($two) <= 0) {
            throw InvalidNumberException::expected('an integer greater than 2', $number->value());
        }

        $candidate = $number->subtract(new BigInteger(1));

        if ($candidate->equals($two)) {
            return $candidate;
        }

        if (!self::isOdd($candidate)) {
            $candidate = $candidate->subtract(new BigInteger(1));
        }

        while (!self::isPrime($candidate)) {
            $candidate = $candidate->subtract($two);
        }

        return $candidate;
    }

    /**
     * Checks whether a number is odd.
     *
     * @param BigInteger $number The number to check.
     */
    private static function isOdd(BigInteger $number): bool
    {
        return !$number->divideRemainder(new BigInteger(2))->isZero();
    }

    /**
     * Runs a single Miller-Rabin round.
     *
     * @param GMP $n         The number under test.
     * @param GMP $nMinusOne The number under test minus one.
     * @param GMP $odd       The odd part of n - 1.
     * @param int $shifts    The exponent of two in n - 1.
     * @param int $witness   The witness.
     *
     * @return bool False if the witness proves that n is composite.
     */
    private static function passesWitness(GMP $n, GMP $nMinusOne, GMP $odd, int $shifts, int $witness): bool
    {
        $x = gmp_powm($witness, $odd, $n);

        if (gmp_cmp($x, 1) === 0 || gmp_cmp($x, $nMinusOne) === 0) {
            return true;
        }

        for ($round = 1; $round < $shifts; $round++) {
            $x = gmp_mod(gmp_mul($x, $x), $n);

            if (gmp_cmp($x, $nMinusOne) === 0) {
                return true;
            }
        }

        return false;
    }
}
