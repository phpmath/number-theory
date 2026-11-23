---
title: Introduction
intro: Number theory for PHP, with primes, factorization, modular arithmetic and more, for integers of any size.
group: Getting started
order: 10
---

## Requirements

The library builds on phpmath/biginteger and uses the GMP extension for the heavy work.

- PHP 8.4 or newer
- The `gmp` extension
- `phpmath/biginteger` 3.0 or newer (installed automatically)

## Installation

Install the library with Composer. This also installs `phpmath/biginteger`.

```bash
composer require phpmath/number-theory
```

## A first example

Numbers are `BigInteger` objects, so there is no limit on their size. This example factors a number that does not fit in 64 bits and then asks for its totient (the count of numbers up to it that share no factor with it).

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Factorizer;
use PHPMath\NumberTheory\Totient;

$number = new BigInteger('18446744073709551617');

echo Factorizer::factorize($number);    // 274177 * 67280421310721
echo Totient::of($number)->value();     // 18446676793287966720
```

Neither call changed `$number`. Every operation returns a new value.

## Where to go next

Start with the core concepts, or jump straight to the topic you need.

<div class="cards"><a href="concepts.md"><strong>Core concepts</strong><span>Static helpers, immutable results, number types and errors.</span></a><a href="divisibility.md"><strong>Divisibility</strong><span>GCD, LCM, coprime numbers and the extended Euclidean algorithm.</span></a><a href="modular-arithmetic.md"><strong>Modular arithmetic</strong><span>Powers, inverses and the Chinese remainder theorem.</span></a><a href="primes.md"><strong>Primes and sieving</strong><span>Primality tests, the next prime and the sieve.</span></a><a href="factorization.md"><strong>Factorization</strong><span>Prime factors, divisors and the totient.</span></a><a href="api.md"><strong>API reference</strong><span>Every method with its parameters and errors.</span></a></div>
