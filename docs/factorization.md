---
title: Factorization
intro: Split a number into primes, then read its divisors and totient.
group: Guides
order: 60
---

## Factoring a number

Every whole number from 2 up is a product of primes in exactly one way. `Factorizer::factorize()` finds that product for a positive integer and returns a `PrimeFactorization`. Printing it gives the primes with their exponents. The factorization of 1 is empty and prints as `1`.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Factorizer;

echo Factorizer::factorize(new BigInteger(360));            // 2^3 * 3^2 * 5
echo Factorizer::factorize(new BigInteger('600851475143')); // 71 * 839 * 1471 * 6857
echo Factorizer::factorize(new BigInteger(97));             // 97
echo Factorizer::factorize(new BigInteger(1));              // 1
```

A number smaller than 1 throws `InvalidNumberException`.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\Factorizer;

try {
    Factorizer::factorize(new BigInteger(0));
} catch (InvalidNumberException $exception) {
    echo $exception->getMessage(); // Expected a positive integer, got 0.
}
```

## How long it takes

The factorizer divides by all primes up to 10 000 first. What remains is split with Pollard's rho, a method that finds a factor in roughly the square root of the size of the second largest prime factor. Numbers with small and medium prime factors are fast. Numbers that are the product of two large primes are slow, and the time grows about ten times for every two extra digits in the factors.

| Number | Measured time |
|---|---|
| Two primes of 6 digits | 0.01 seconds |
| Two primes of 10 digits | 0.1 to 0.4 seconds |
| Two primes of 12 digits | 1 to 3 seconds |

These times come from one test machine in Docker, so treat them as a rough guide. The two primes in each case were close together, and the time varies from one pair to the next. Extending the pattern, two primes of 20 digits each would take hours.

> [!WARNING]
> There is no time limit. A number made of two primes of 20 digits or more does not finish in a practical time. Do not factor numbers from untrusted input without a time limit of your own.

## Reading a factorization

A `PrimeFactorization` is an immutable object. `toArray()` maps each prime to its exponent, `primes()` lists the distinct primes as `BigInteger` objects, `exponentOf()` looks up one prime (0 if it is not a factor) and `distinctPrimeCount()` counts the distinct primes.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Factorizer;

$factorization = Factorizer::factorize(new BigInteger(360));

echo json_encode($factorization->toArray());                  // {"2":3,"3":2,"5":1}
echo $factorization->exponentOf(new BigInteger(2));           // 3
echo $factorization->exponentOf(new BigInteger(7));           // 0
echo $factorization->distinctPrimeCount();                    // 3
echo $factorization->primes()[2]->value();                    // 5
```

> [!NOTE]
> The keys of `toArray()` are the primes written as decimal strings. PHP turns a key that fits in an integer into an integer, so small primes are integer keys. Do not rely on the key type.

`product()` multiplies the prime powers back together, and `isOne()` tells whether this is the empty factorization of 1.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Factorizer;

$factorization = Factorizer::factorize(new BigInteger(360));

echo $factorization->product()->value();   // 360
var_dump($factorization->isOne());         // bool(false)
var_dump(Factorizer::factorize(new BigInteger(1))->isOne()); // bool(true)
```

## Divisors

`divisorCount()` returns the number of positive divisors without listing them. `divisors()` returns all of them in ascending order. The list has `divisorCount()` entries, which can be very large, so only call `divisors()` when you need the list.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Factorizer;

$factorization = Factorizer::factorize(new BigInteger(360));

echo $factorization->divisorCount(); // 24

$divisors = array_map(fn (BigInteger $divisor): string => $divisor->value(), $factorization->divisors());

echo implode(' ', $divisors); // 1 2 3 4 5 6 8 9 10 12 15 18 20 24 30 36 40 45 60 72 90 120 180 360
```

## The totient

Euler's totient of a number n counts the integers from 1 to n that are coprime to n. For example, the totient of 360 is 96. `Totient::of()` factors the number first, so the speed limits above apply. `PrimeFactorization::totient()` gives the same result when you already have a factorization.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Factorizer;
use PHPMath\NumberTheory\Totient;

echo Totient::of(new BigInteger(360))->value();            // 96
echo Totient::of(new BigInteger(97))->value();             // 96
echo Totient::of(new BigInteger(1))->value();              // 1
echo Factorizer::factorize(new BigInteger(360))->totient()->value(); // 96
```

`Totient::of()` throws `InvalidNumberException` for a number smaller than 1.

## Building a factorization yourself

You can create a `PrimeFactorization` from a map of primes to exponents. The primes are sorted for you. Every key must be a prime and every exponent must be at least 1, or `InvalidNumberException` is thrown. An empty map gives the factorization of 1. The keys are checked with `Primality::isPrime()`, which is exact below `Primality::DETERMINISTIC_BOUND` (3317044064679887385961981) and probabilistic from there on.

```php
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\PrimeFactorization;

echo new PrimeFactorization([5 => 1, 2 => 3]); // 2^3 * 5
echo new PrimeFactorization([]);               // 1

try {
    new PrimeFactorization([4 => 1]);
} catch (InvalidNumberException $exception) {
    echo $exception->getMessage(); // Expected a prime number, got 4.
}
```
