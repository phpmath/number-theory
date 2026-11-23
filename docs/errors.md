---
title: Errors and exceptions
intro: What can go wrong and how to catch it.
group: Reference
order: 100
---

## Library exceptions

Every exception the library throws on purpose implements the marker interface `PHPMath\NumberTheory\Exception\NumberTheoryException`, so one `catch` block handles all of them. All exceptions live in `PHPMath\NumberTheory\Exception` and are `final`. Each one also extends an exception from PHP, which says what kind of problem it is:

- `InvalidArgumentException`: an argument has an invalid value, such as a zero or negative modulus.
- `DomainException`: the arguments are fine in general, but the result is mathematically undefined for them, such as a number without an inverse.

| Exception | Extends | Thrown when |
|---|---|---|
| `InvalidModulusException` | `InvalidArgumentException` | A modulus is zero or negative. |
| `NotInvertibleException` | `DomainException` | A value has no inverse because it is not coprime with the modulus. |
| `InvalidNumberException` | `InvalidArgumentException` | A number does not meet a requirement, such as being positive, odd or prime. |
| `NegativeArgumentException` | `InvalidArgumentException` | A plain `int` argument is negative. |
| `LimitTooLargeException` | `InvalidArgumentException` | A limit is larger than the maximum, as for `PrimeSieve::primesUpTo()`. |
| `EmptyCongruenceSystemException` | `InvalidArgumentException` | `ChineseRemainder::solve()` gets no congruence. |
| `UnsolvableCongruenceException` | `DomainException` | A system of congruences has no solution. |

Exceptions from the BigInteger library do not leak out of the number theory methods once their arguments are validated. `ModularArithmetic::inverse()` reports a missing inverse as its own `NotInvertibleException`.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\NumberTheoryException;
use PHPMath\NumberTheory\ModularArithmetic;

try {
    ModularArithmetic::inverse(new BigInteger(6), new BigInteger(9));
} catch (NumberTheoryException $exception) {
    echo $exception->getMessage(); // 6 has no inverse modulo 9 because they are not coprime.
}
```

## When each exception is thrown

This table lists every case where a method rejects its input.

| Method | Exception | Condition |
|---|---|---|
| `new Congruence()` | `InvalidModulusException` | The modulus is not positive. |
| `ModularArithmetic::powMod()` | `InvalidModulusException` | The modulus is not positive. |
| `ModularArithmetic::powMod()` | `NotInvertibleException` | The exponent is negative and the base has no inverse. |
| `ModularArithmetic::inverse()` | `InvalidModulusException` | The modulus is not positive. |
| `ModularArithmetic::inverse()` | `NotInvertibleException` | The value and the modulus are not coprime. |
| `ChineseRemainder::solve()` | `EmptyCongruenceSystemException` | No congruence is given. |
| `ChineseRemainder::solve()` | `UnsolvableCongruenceException` | The congruences contradict each other. |
| `Primality::previousPrime()` | `InvalidNumberException` | The number is not greater than 2. |
| `Factorizer::factorize()` | `InvalidNumberException` | The number is smaller than 1. |
| `Totient::of()` | `InvalidNumberException` | The number is smaller than 1. |
| `new PrimeFactorization()` | `InvalidNumberException` | A key is not a prime, or an exponent is smaller than 1. The prime check is exact below 3317044064679887385961981 and probabilistic from there on. |
| `Symbols::jacobi()` | `InvalidNumberException` | The denominator is not a positive odd integer. |
| `Symbols::legendre()` | `InvalidNumberException` | The denominator is not an odd prime. The prime check is exact below 3317044064679887385961981 and probabilistic from there on. |
| `PrimeSieve::primesUpTo()` | `NegativeArgumentException` | The limit is negative. |
| `PrimeSieve::primesUpTo()` | `LimitTooLargeException` | The limit is greater than `PrimeSieve::MAX_LIMIT` (10 000 000). |
| `Sequences::fibonacci()` | `NegativeArgumentException` | The index is negative. |
| `Sequences::factorial()` | `NegativeArgumentException` | The number is negative. |

## Handling untrusted input

Catch the marker interface when you only need to know that the input was bad. Wrapping the value in a `BigInteger` can also fail. That exception comes from the BigInteger library and implements its own marker, `BigIntegerException`.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\BigInteger\Exception\InvalidValueException;
use PHPMath\NumberTheory\Exception\NumberTheoryException;
use PHPMath\NumberTheory\ModularArithmetic;

try {
    $value = new BigInteger($_POST['value']);
    $modulus = new BigInteger($_POST['modulus']);

    $inverse = ModularArithmetic::inverse($value, $modulus);
} catch (InvalidValueException) {
    // not a whole number
} catch (NumberTheoryException) {
    // not positive, or no inverse exists
}
```
