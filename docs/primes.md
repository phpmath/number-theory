---
title: Primes and sieving
intro: Test numbers for primality, find neighbouring primes and list all primes up to a limit.
group: Guides
order: 50
---

## Testing for primes

A prime is a whole number greater than 1 that only 1 and itself divide. `Primality::isPrime()` returns a boolean. Numbers below 2, including negative numbers, are never prime.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Primality;

var_dump(Primality::isPrime(new BigInteger(97)));   // bool(true)
var_dump(Primality::isPrime(new BigInteger(561)));  // bool(false)
var_dump(Primality::isPrime(new BigInteger(1)));    // bool(false)
var_dump(Primality::isPrime(new BigInteger(-7)));   // bool(false)

// 2^127 - 1, a Mersenne prime
var_dump(Primality::isPrime(new BigInteger('170141183460469231731687303715884105727'))); // bool(true)
```

## When the answer is exact

The test is the Miller-Rabin test, which checks a number against a list of small primes called witnesses. Below `Primality::DETERMINISTIC_BOUND`, which is 3317044064679887385961981 (about 3.3 * 10^24), the first 13 primes are used as witnesses. This is proven to give the right answer for every number below the bound.

From the bound on, the library uses the first 20 primes. A composite number is then rejected with overwhelming probability, but a number that was crafted on purpose to fool those witnesses could be reported as prime. For numbers that nobody crafted this does not happen in practice.

> [!WARNING]
> Do not rely on `isPrime()` as a proof for numbers at or above the bound, for example in security checks on input that an attacker controls.

## Checking if the answer is proven

`Primality::isExact()` tells you which case applies to a number. It returns `true` when the number is below the bound, so the answer of `isPrime()` is proven.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Primality;

echo Primality::DETERMINISTIC_BOUND; // 3317044064679887385961981

var_dump(Primality::isExact(new BigInteger('3317044064679887385961979'))); // bool(true)
var_dump(Primality::isExact(new BigInteger('3317044064679887385961981'))); // bool(false)
```

## The next and previous prime

`nextPrime()` returns the smallest prime that is strictly greater than the number. For numbers below 2 it returns 2. `previousPrime()` returns the largest prime that is strictly smaller. It needs a number greater than 2, because there is no prime below 2.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Primality;

echo Primality::nextPrime(new BigInteger(100))->value();           // 101
echo Primality::nextPrime(new BigInteger(-5))->value();            // 2
echo Primality::nextPrime(new BigInteger('1000000000000'))->value(); // 1000000000039
echo Primality::previousPrime(new BigInteger(100))->value();       // 97
echo Primality::previousPrime(new BigInteger(3))->value();         // 2
```

Both methods test candidates with `isPrime()`, so they share its bound.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\Primality;

try {
    Primality::previousPrime(new BigInteger(2));
} catch (InvalidNumberException $exception) {
    echo $exception->getMessage(); // Expected an integer greater than 2, got 2.
}
```

## Listing primes with a sieve

A sieve finds all primes up to a limit at once, by crossing out the multiples of every prime. `PrimeSieve::primesUpTo()` takes a plain `int` and returns a list of PHP integers in ascending order. The limit itself is included.

```php
use PHPMath\NumberTheory\PrimeSieve;

echo json_encode(PrimeSieve::primesUpTo(30));   // [2,3,5,7,11,13,17,19,23,29]
echo json_encode(PrimeSieve::primesUpTo(2));    // [2]
echo json_encode(PrimeSieve::primesUpTo(1));    // []
echo count(PrimeSieve::primesUpTo(1000000));    // 78498
```

A negative limit throws `NegativeArgumentException`, and a limit above `PrimeSieve::MAX_LIMIT` (10 000 000) throws `LimitTooLargeException`.

```php
use PHPMath\NumberTheory\Exception\NegativeArgumentException;
use PHPMath\NumberTheory\PrimeSieve;

try {
    PrimeSieve::primesUpTo(-1);
} catch (NegativeArgumentException $exception) {
    echo $exception->getMessage(); // The argument "limit" must not be negative, got -1.
}
```

```php
use PHPMath\NumberTheory\Exception\LimitTooLargeException;
use PHPMath\NumberTheory\PrimeSieve;

echo PrimeSieve::MAX_LIMIT; // 10000000

try {
    PrimeSieve::primesUpTo(PHP_INT_MAX);
} catch (LimitTooLargeException $exception) {
    echo $exception->getMessage(); // The limit must not be greater than 10000000, got 9223372036854775807.
}
```

## Limits of the sieve

The sieve needs about one byte per number up to the limit, plus the memory of the returned list. To keep a sieve from exhausting the memory, the limit is capped at `PrimeSieve::MAX_LIMIT`, which is 10 000 000. A sieve up to that limit returns 664 579 primes in about 2 seconds and peaks at about 38 MB, well within the default PHP memory limit of 128 MB. A larger limit throws `LimitTooLargeException` before any memory is allocated.

> [!NOTE]
> The limit is a plain `int`. A limit below 2 gives an empty list, a negative limit throws `NegativeArgumentException`.
