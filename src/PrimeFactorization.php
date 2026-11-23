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

use function count;
use function implode;
use function preg_match;
use function usort;

/**
 * The prime factorization of a positive integer: a map of distinct primes to their exponents.
 *
 * The factorization of 1 is empty. Primes are always kept in ascending order.
 */
final readonly class PrimeFactorization
{
    /**
     * The distinct primes with their exponents, in ascending order of the prime.
     *
     * @var list<array{prime: BigInteger, exponent: int}>
     */
    private array $factors;

    /**
     * Initializes a new factorization.
     *
     * Every key is validated with {@see Primality::isPrime()}, which is exact below
     * {@see Primality::DETERMINISTIC_BOUND} and probabilistic from there on.
     *
     * @param array<int|string, int> $factors Maps each prime to its exponent. The prime is the key, written as a
     *     decimal string (PHP turns keys that fit in an int into ints, both are accepted).
     *
     * @throws InvalidNumberException Thrown if a key is not a prime or an exponent is smaller than 1.
     */
    public function __construct(array $factors)
    {
        $list = [];

        foreach ($factors as $prime => $exponent) {
            $text = (string)$prime;

            if (preg_match('/^[0-9]+$/D', $text) !== 1 || !Primality::isPrime(new BigInteger($text))) {
                throw InvalidNumberException::expected('a prime number', $text);
            }

            if ($exponent < 1) {
                throw InvalidNumberException::expected('an exponent of at least 1', (string)$exponent);
            }

            $list[] = ['prime' => new BigInteger($text), 'exponent' => $exponent];
        }

        usort($list, static fn (array $a, array $b): int => $a['prime']->cmp($b['prime']));

        $this->factors = $list;
    }

    /**
     * Returns the map of primes to exponents.
     *
     * The keys are the decimal strings of the primes, but PHP converts keys that fit in an int to ints.
     *
     * @return array<int|string, int>
     */
    public function toArray(): array
    {
        $map = [];

        foreach ($this->factors as $factor) {
            $map[$factor['prime']->value()] = $factor['exponent'];
        }

        return $map;
    }

    /**
     * Returns the distinct primes in ascending order.
     *
     * @return list<BigInteger>
     */
    public function primes(): array
    {
        $primes = [];

        foreach ($this->factors as $factor) {
            $primes[] = $factor['prime'];
        }

        return $primes;
    }

    /**
     * Returns the exponent of a prime, or 0 if the prime is not a factor.
     *
     * @param BigInteger $prime The prime to look up.
     */
    public function exponentOf(BigInteger $prime): int
    {
        foreach ($this->factors as $factor) {
            if ($factor['prime']->equals($prime)) {
                return $factor['exponent'];
            }
        }

        return 0;
    }

    /**
     * Returns the number of distinct primes.
     */
    public function distinctPrimeCount(): int
    {
        return count($this->factors);
    }

    /**
     * Checks whether this is the empty factorization of 1.
     */
    public function isOne(): bool
    {
        return $this->factors === [];
    }

    /**
     * Multiplies the prime powers back together.
     */
    public function product(): BigInteger
    {
        $product = new BigInteger(1);

        foreach ($this->factors as $factor) {
            $product = $product->multiply($factor['prime']->pow($factor['exponent']));
        }

        return $product;
    }

    /**
     * Returns the number of positive divisors.
     */
    public function divisorCount(): int
    {
        $count = 1;

        foreach ($this->factors as $factor) {
            $count *= $factor['exponent'] + 1;
        }

        return $count;
    }

    /**
     * Returns all positive divisors in ascending order.
     *
     * The list has {@see divisorCount()} entries, which can be very large.
     *
     * @return list<BigInteger>
     */
    public function divisors(): array
    {
        $divisors = [new BigInteger(1)];

        foreach ($this->factors as $factor) {
            $expanded = [];

            foreach ($divisors as $divisor) {
                $power = $divisor;
                $expanded[] = $power;

                for ($i = 1; $i <= $factor['exponent']; $i++) {
                    $power = $power->multiply($factor['prime']);
                    $expanded[] = $power;
                }
            }

            $divisors = $expanded;
        }

        usort($divisors, static fn (BigInteger $a, BigInteger $b): int => $a->cmp($b));

        return $divisors;
    }

    /**
     * Computes Euler's totient of the number this factorization represents.
     */
    public function totient(): BigInteger
    {
        $totient = new BigInteger(1);

        foreach ($this->factors as $factor) {
            $totient = $totient->multiply($factor['prime']->pow($factor['exponent'] - 1))
                ->multiply($factor['prime']->subtract(new BigInteger(1)));
        }

        return $totient;
    }

    /**
     * Returns the factorization as text, for example "2^3 * 5". The exponent 1 is omitted, 1 is written as "1".
     */
    public function __toString(): string
    {
        if ($this->factors === []) {
            return '1';
        }

        $parts = [];

        foreach ($this->factors as $factor) {
            $parts[] = $factor['exponent'] === 1
                ? $factor['prime']->value()
                : $factor['prime']->value() . '^' . $factor['exponent'];
        }

        return implode(' * ', $parts);
    }
}
