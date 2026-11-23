---
title: Core concepts
intro: The few ideas you need to use the library well.
group: Getting started
order: 20
---

## Static helper classes

Most classes are collections of static methods, such as `Divisibility`, `ModularArithmetic`, `Primality`, `PrimeSieve`, `Factorizer`, `Totient`, `Symbols`, `Sequences` and `ChineseRemainder`. They are `final` and cannot be instantiated. You call their methods directly.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Divisibility;

echo Divisibility::gcd(new BigInteger(12), new BigInteger(18))->value(); // 6
```

## Immutable results

The classes that hold a result are `final readonly` value objects: `Congruence`, `ExtendedGcd` and `PrimeFactorization`. Once created they never change. You read their data through public properties or methods.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Congruence;

$congruence = new Congruence(new BigInteger(-1), new BigInteger(5));

echo $congruence;                      // x = 4 (mod 5)
echo $congruence->remainder->value();  // 4
```

A `Congruence` normalizes its remainder into the range 0 up to the modulus, which is why `-1` became `4`.

## Accepted number types

Methods that work on big numbers take `BigInteger` objects, not strings or PHP integers. Wrap raw values first. Pass large numbers as strings, because a PHP integer literal above `PHP_INT_MAX` is turned into a float before the library sees it.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Primality;

$prime = new BigInteger('170141183460469231731687303715884105727');

var_dump(Primality::isPrime($prime)); // bool(true)
```

Some methods take a plain PHP `int` because the value is a count or an index: `PrimeSieve::primesUpTo()`, `Sequences::fibonacci()` and `Sequences::factorial()`. The symbols return a plain `int` (-1, 0 or 1) and the exponents of a factorization are plain integers too.

> [!NOTE]
> See the BigInteger documentation for everything you can do with a `BigInteger`, such as arithmetic and comparison.

## Errors

Invalid input throws a specific exception from `PHPMath\NumberTheory\Exception`. Each method lists what it throws in the [API reference](api.md), and [Errors and exceptions](errors.md) lists every exception class. All of them implement `NumberTheoryException`, so you can catch that interface to handle any of them.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidModulusException;
use PHPMath\NumberTheory\ModularArithmetic;

try {
    ModularArithmetic::inverse(new BigInteger(5), new BigInteger(0));
} catch (InvalidModulusException $exception) {
    echo $exception->getMessage(); // The modulus must be a positive integer, got 0.
}
```

## Exact and probabilistic results

Almost every answer is exact. Two things are not: the primality test is only proven exact below a stated bound, and factoring very large numbers can take impractically long. See [Primes and sieving](primes.md) and [Factorization](factorization.md).
