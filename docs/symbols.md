---
title: Symbols
intro: The Jacobi and Legendre symbols, which tell whether a number is a square modulo another number.
group: Guides
order: 70
---

## The Jacobi symbol

A number `a` is a square modulo `n` when some number `x` gives `x * x = a (mod n)`. The Jacobi symbol `(a / n)` is a helper for this question. It is `1`, `-1` or `0`, and it is `0` exactly when `a` and `n` share a factor. The denominator `n` must be a positive odd integer. The numerator can be any integer.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Symbols;

echo Symbols::jacobi(new BigInteger(1001), new BigInteger(9907)); // -1
echo Symbols::jacobi(new BigInteger(2), new BigInteger(15));      // 1
echo Symbols::jacobi(new BigInteger(5), new BigInteger(15));      // 0
echo Symbols::jacobi(new BigInteger(-1), new BigInteger(7));      // -1
echo Symbols::jacobi(new BigInteger(3), new BigInteger(1));       // 1
```

A denominator that is even, zero or negative throws `InvalidNumberException`.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\Symbols;

try {
    Symbols::jacobi(new BigInteger(3), new BigInteger(4));
} catch (InvalidNumberException $exception) {
    echo $exception->getMessage(); // Expected a positive odd integer, got 4.
}
```

## The Legendre symbol

The Legendre symbol `(a / p)` is the Jacobi symbol for a prime `p`. It is `1` if `a` is a non-zero square modulo `p`, `-1` if it is not a square, and `0` if `p` divides `a`. The denominator must be an odd prime.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Symbols;

echo Symbols::legendre(new BigInteger(5), new BigInteger(11));  // 1
echo Symbols::legendre(new BigInteger(2), new BigInteger(11));  // -1
echo Symbols::legendre(new BigInteger(11), new BigInteger(11)); // 0
echo Symbols::legendre(new BigInteger(-1), new BigInteger(13)); // 1
```

The method checks the denominator with `Primality::isPrime()`. A denominator that is not an odd prime, such as 2, 9 or 1, throws `InvalidNumberException`. The check is exact below 3317044064679887385961981 and probabilistic from there on, see [Primes and sieving](primes.md).

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\Symbols;

try {
    Symbols::legendre(new BigInteger(3), new BigInteger(9));
} catch (InvalidNumberException $exception) {
    echo $exception->getMessage(); // Expected an odd prime, got 9.
}
```

> [!NOTE]
> BigInteger can compute both symbols itself, but without checking the denominator. These methods validate it first and throw a clear exception.
