---
title: API reference
intro: Every public method of every class, grouped by purpose.
group: Reference
order: 90
layout: reference
---

All classes belong to the namespace `PHPMath\NumberTheory`. The exceptions belong to `PHPMath\NumberTheory\Exception`. Numbers are `BigInteger` objects from `PHPMath\BigInteger\BigInteger` unless a parameter is typed `int`. Classes in the `PHPMath\NumberTheory\Internal` namespace, such as `GmpBridge`, are internal. They are not listed here and are not covered by the stability promise, so do not use them.

## Divisibility

Divisors, greatest common divisor, least common multiple and the extended Euclidean algorithm. A `final` class of static methods.

### divides()

```php
public static function divides(BigInteger $divisor, BigInteger $value): bool
```

Checks whether the divisor divides the value without a remainder. Zero only divides zero.

- **Parameters:** `$divisor` the divisor, `$value` the value to divide
- **Returns:** `bool`

### isCoprime()

```php
public static function isCoprime(BigInteger $a, BigInteger $b): bool
```

Checks whether two numbers share no prime factor, which means their gcd is 1.

- **Parameters:** `$a` the first number, `$b` the second number
- **Returns:** `bool`

### gcd()

```php
public static function gcd(BigInteger $a, BigInteger $b): BigInteger
```

Returns the non-negative greatest common divisor.

- **Parameters:** `$a` the first number, `$b` the second number
- **Returns:** `BigInteger`

### lcm()

```php
public static function lcm(BigInteger $a, BigInteger $b): BigInteger
```

Returns the non-negative least common multiple.

- **Parameters:** `$a` the first number, `$b` the second number
- **Returns:** `BigInteger`

### extendedGcd()

```php
public static function extendedGcd(BigInteger $a, BigInteger $b): ExtendedGcd
```

Runs the extended Euclidean algorithm.

- **Parameters:** `$a` the first number, `$b` the second number
- **Returns:** `ExtendedGcd` with the gcd and coefficients `x` and `y` for which `a * x + b * y = gcd`

## ExtendedGcd

The immutable result of the extended Euclidean algorithm. It is a `final readonly` class with the public properties `gcd`, `x` and `y`, all of type `BigInteger`. For the inputs a and b it holds that `a * x + b * y = gcd`.

### __construct()

```php
public function __construct(BigInteger $gcd, BigInteger $x, BigInteger $y)
```

Creates a result. The values are not checked against any inputs.

- **Parameters:** `$gcd` the non-negative gcd, `$x` the coefficient of the first input, `$y` the coefficient of the second input

### satisfiesBezout()

```php
public function satisfiesBezout(BigInteger $a, BigInteger $b): bool
```

Checks that `a * x + b * y` equals the gcd.

- **Parameters:** `$a` the first input of the algorithm, `$b` the second input of the algorithm
- **Returns:** `bool`

## ModularArithmetic

Modular exponentiation and modular inverses. A `final` class of static methods.

### powMod()

```php
public static function powMod(BigInteger $base, BigInteger $exponent, BigInteger $modulus): BigInteger
```

Computes `base^exponent mod modulus` in the range 0 up to the modulus. A negative exponent raises the modular inverse of the base to the absolute value of the exponent.

- **Parameters:** `$base` the base, `$exponent` the exponent, `$modulus` the modulus, must be positive
- **Returns:** `BigInteger`
- **Throws:** [InvalidModulusException](errors.md) if the modulus is not positive; [NotInvertibleException](errors.md) if the exponent is negative and the base has no inverse

### inverse()

```php
public static function inverse(BigInteger $value, BigInteger $modulus): BigInteger
```

Computes the number `x` with `value * x = 1 (mod modulus)` and 0 <= x < modulus. Modulo 1 the result is 0.

- **Parameters:** `$value` the value to invert, `$modulus` the modulus, must be positive
- **Returns:** `BigInteger`
- **Throws:** [InvalidModulusException](errors.md) if the modulus is not positive; [NotInvertibleException](errors.md) if the value and the modulus are not coprime

## Congruence

A congruence: x is congruent to a remainder modulo a modulus. It is a `final readonly` class with the public properties `remainder` and `modulus`, both `BigInteger`. The remainder is normalized into the range 0 up to the modulus.

### __construct()

```php
public function __construct(BigInteger $remainder, BigInteger $modulus)
```

Creates a congruence.

- **Parameters:** `$remainder` any integer, it is normalized, `$modulus` the modulus, must be positive
- **Throws:** [InvalidModulusException](errors.md) if the modulus is not positive

### isSatisfiedBy()

```php
public function isSatisfiedBy(BigInteger $value): bool
```

Checks whether a number satisfies this congruence.

- **Parameters:** `$value` the number to test
- **Returns:** `bool`

### __toString()

```php
public function __toString(): string
```

Returns the congruence as text, for example `x = 2 (mod 3)`.

- **Returns:** `string`

## ChineseRemainder

Solves systems of simultaneous congruences. The moduli do not have to be pairwise coprime. A `final` class of static methods.

### solve()

```php
public static function solve(Congruence ...$congruences): Congruence
```

Solves a system of congruences.

- **Parameters:** `...$congruences` the congruences to satisfy at the same time
- **Returns:** `Congruence` where x is congruent to the remainder modulo the lcm of all moduli
- **Throws:** [EmptyCongruenceSystemException](errors.md) if no congruence is given; [UnsolvableCongruenceException](errors.md) if the system is inconsistent

## Primality

Primality testing and prime search. The test is exact below `DETERMINISTIC_BOUND` and probabilistic from there on. The class has the constant `DETERMINISTIC_BOUND`, the string `3317044064679887385961981`. A `final` class of static methods.

### isPrime()

```php
public static function isPrime(BigInteger $number): bool
```

Checks whether a number is prime. Numbers below 2 are not prime. The answer is proven below `DETERMINISTIC_BOUND` and probabilistic from there on.

- **Parameters:** `$number` the number to test
- **Returns:** `bool`

### isExact()

```php
public static function isExact(BigInteger $number): bool
```

Tells whether `isPrime()` gives a proven answer for this number, which is the case when the number is below `DETERMINISTIC_BOUND`.

- **Parameters:** `$number` the number that is tested
- **Returns:** `bool`

### nextPrime()

```php
public static function nextPrime(BigInteger $number): BigInteger
```

Returns the smallest prime that is strictly greater than the number. Numbers below 2 give 2.

- **Parameters:** `$number` the lower bound, exclusive
- **Returns:** `BigInteger`

### previousPrime()

```php
public static function previousPrime(BigInteger $number): BigInteger
```

Returns the largest prime that is strictly smaller than the number.

- **Parameters:** `$number` the upper bound, exclusive, must be greater than 2
- **Returns:** `BigInteger`
- **Throws:** [InvalidNumberException](errors.md) if the number is not greater than 2

## PrimeSieve

Generates primes with the sieve of Eratosthenes. The sieve needs about one byte per number up to the limit. The class has the constant `MAX_LIMIT`, the int `10000000`, which is the largest accepted limit. A `final` class of static methods.

### primesUpTo()

```php
public static function primesUpTo(int $limit): array
```

Returns all primes less than or equal to the limit in ascending order.

- **Parameters:** `$limit` the inclusive upper bound, at most `MAX_LIMIT`
- **Returns:** `list<int>` the primes up to and including the limit
- **Throws:** [NegativeArgumentException](errors.md) if the limit is negative; [LimitTooLargeException](errors.md) if the limit is greater than `MAX_LIMIT`

## Factorizer

Splits integers into their prime factors with trial division and Pollard's rho. Two close primes of 12 digits each take about 1 to 3 seconds and the time grows about ten times for every two extra digits (a rough guide), so very large semiprimes take impractically long. A `final` class of static methods.

### factorize()

```php
public static function factorize(BigInteger $number): PrimeFactorization
```

Computes the prime factorization of a positive integer.

- **Parameters:** `$number` the number to factor, must be at least 1
- **Returns:** `PrimeFactorization`
- **Throws:** [InvalidNumberException](errors.md) if the number is smaller than 1

## PrimeFactorization

The prime factorization of a positive integer: a map of distinct primes to their exponents. It is a `final readonly` class. The factorization of 1 is empty and the primes are always in ascending order.

### __construct()

```php
public function __construct(array $factors)
```

Creates a factorization from a map of primes to exponents. The prime is the key, written as a decimal string or an int.

- **Parameters:** `$factors` `array<int|string, int>` mapping each prime to its exponent. The prime check is exact below 3317044064679887385961981 and probabilistic from there on.
- **Throws:** [InvalidNumberException](errors.md) if a key is not a prime or an exponent is smaller than 1

### toArray()

```php
public function toArray(): array
```

Returns the map of primes to exponents. PHP turns keys that fit in an int into ints.

- **Returns:** `array<int|string, int>`

### primes()

```php
public function primes(): array
```

Returns the distinct primes in ascending order.

- **Returns:** `list<BigInteger>`

### exponentOf()

```php
public function exponentOf(BigInteger $prime): int
```

Returns the exponent of a prime, or 0 if the prime is not a factor.

- **Parameters:** `$prime` the prime to look up
- **Returns:** `int`

### distinctPrimeCount()

```php
public function distinctPrimeCount(): int
```

Returns the number of distinct primes.

- **Returns:** `int`

### isOne()

```php
public function isOne(): bool
```

Checks whether this is the empty factorization of 1.

- **Returns:** `bool`

### product()

```php
public function product(): BigInteger
```

Multiplies the prime powers back together.

- **Returns:** `BigInteger`

### divisorCount()

```php
public function divisorCount(): int
```

Returns the number of positive divisors.

- **Returns:** `int`

### divisors()

```php
public function divisors(): array
```

Returns all positive divisors in ascending order. The list has `divisorCount()` entries, which can be very large.

- **Returns:** `list<BigInteger>`

### totient()

```php
public function totient(): BigInteger
```

Computes Euler's totient of the number this factorization represents.

- **Returns:** `BigInteger`

### __toString()

```php
public function __toString(): string
```

Returns the factorization as text, for example `2^3 * 5`. The exponent 1 is omitted and 1 is written as `1`.

- **Returns:** `string`

## Totient

Euler's totient function. A `final` class of static methods.

### of()

```php
public static function of(BigInteger $number): BigInteger
```

Counts the integers from 1 to n that are coprime to n. The number is factored first, so the limits of `Factorizer` apply.

- **Parameters:** `$number` the number, must be at least 1
- **Returns:** `BigInteger`
- **Throws:** [InvalidNumberException](errors.md) if the number is smaller than 1

## Symbols

The Jacobi and Legendre symbols, with validation of the denominator. A `final` class of static methods.

### jacobi()

```php
public static function jacobi(BigInteger $a, BigInteger $n): int
```

Computes the Jacobi symbol (a / n).

- **Parameters:** `$a` the numerator, any integer, `$n` the denominator, must be a positive odd integer
- **Returns:** `int` -1, 0 or 1
- **Throws:** [InvalidNumberException](errors.md) if n is not a positive odd integer

### legendre()

```php
public static function legendre(BigInteger $a, BigInteger $p): int
```

Computes the Legendre symbol (a / p): 1 if a is a non-zero square modulo p, -1 if it is a non-square and 0 if p divides a.

- **Parameters:** `$a` the numerator, any integer, `$p` the denominator, must be an odd prime. The prime check is exact below 3317044064679887385961981 and probabilistic from there on.
- **Returns:** `int` -1, 0 or 1
- **Throws:** [InvalidNumberException](errors.md) if p is not an odd prime

## Sequences

Fibonacci numbers and factorials. A `final` class of static methods.

### fibonacci()

```php
public static function fibonacci(int $n): BigInteger
```

Returns the n-th Fibonacci number, with F(0) = 0 and F(1) = 1.

- **Parameters:** `$n` the index, must not be negative
- **Returns:** `BigInteger`
- **Throws:** [NegativeArgumentException](errors.md) if n is negative

### factorial()

```php
public static function factorial(int $n): BigInteger
```

Returns n!, with 0! = 1.

- **Parameters:** `$n` the number, must not be negative
- **Returns:** `BigInteger`
- **Throws:** [NegativeArgumentException](errors.md) if n is negative

## Exceptions

The `final` exception classes each implement the marker interface `NumberTheoryException` and have one static factory method that the library uses to create them. You normally only catch them. See [Errors and exceptions](errors.md) for when each one is thrown.

### EmptyCongruenceSystemException::create()

```php
public static function create(): self
```

Creates the exception with the message "At least one congruence is required.".

- **Returns:** `EmptyCongruenceSystemException`

### InvalidModulusException::fromModulus()

```php
public static function fromModulus(string $modulus): self
```

Creates the exception for a rejected modulus.

- **Parameters:** `$modulus` the decimal text of the modulus
- **Returns:** `InvalidModulusException`

### InvalidNumberException::expected()

```php
public static function expected(string $requirement, string $value): self
```

Creates the exception with a description of the violated requirement.

- **Parameters:** `$requirement` what the number should have been, `$value` the decimal text of the rejected number
- **Returns:** `InvalidNumberException`

### LimitTooLargeException::exceeds()

```php
public static function exceeds(int $limit, int $maximum): self
```

Creates the exception for a limit above the maximum. It extends `InvalidArgumentException`.

- **Parameters:** `$limit` the rejected limit, `$maximum` the largest accepted limit
- **Returns:** `LimitTooLargeException`

### NegativeArgumentException::forArgument()

```php
public static function forArgument(string $name, int $value): self
```

Creates the exception for a negative argument.

- **Parameters:** `$name` the name of the argument, `$value` the rejected value
- **Returns:** `NegativeArgumentException`

### NotInvertibleException::fromValues()

```php
public static function fromValues(string $value, string $modulus): self
```

Creates the exception for a value without an inverse. It extends `DomainException`.

- **Parameters:** `$value` the decimal text of the value, `$modulus` the decimal text of the modulus
- **Returns:** `NotInvertibleException`

### UnsolvableCongruenceException::inconsistent()

```php
public static function inconsistent(): self
```

Creates the exception for an inconsistent system. It extends `DomainException`.

- **Returns:** `UnsolvableCongruenceException`
