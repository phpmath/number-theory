---
title: Divisibility
intro: Divisors, GCD, LCM, coprime numbers and the extended Euclidean algorithm.
group: Guides
order: 30
---

## Dividing and coprime numbers

`Divisibility::divides()` tells you whether a divisor goes into a value without a remainder. Zero only divides zero. `isCoprime()` tells you whether two numbers share no prime factor, which means their greatest common divisor is 1.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Divisibility;

var_dump(Divisibility::divides(new BigInteger(3), new BigInteger(12)));  // bool(true)
var_dump(Divisibility::divides(new BigInteger(5), new BigInteger(12)));  // bool(false)
var_dump(Divisibility::divides(new BigInteger(0), new BigInteger(0)));   // bool(true)
var_dump(Divisibility::divides(new BigInteger(0), new BigInteger(5)));   // bool(false)
var_dump(Divisibility::isCoprime(new BigInteger(8), new BigInteger(15))); // bool(true)
var_dump(Divisibility::isCoprime(new BigInteger(12), new BigInteger(18))); // bool(false)
```

## GCD and LCM

The greatest common divisor (gcd) is the largest number that divides both inputs. The least common multiple (lcm) is the smallest positive number that both inputs divide. Both results are never negative, whatever the signs of the inputs.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Divisibility;

echo Divisibility::gcd(new BigInteger(12), new BigInteger(18))->value();  // 6
echo Divisibility::gcd(new BigInteger(-12), new BigInteger(18))->value(); // 6
echo Divisibility::gcd(new BigInteger(0), new BigInteger(0))->value();    // 0
echo Divisibility::lcm(new BigInteger(12), new BigInteger(18))->value();  // 36
echo Divisibility::lcm(new BigInteger(-4), new BigInteger(6))->value();   // 12
echo Divisibility::lcm(new BigInteger(0), new BigInteger(5))->value();    // 0
```

> [!NOTE]
> These two methods are thin wrappers around `greatestCommonDivisor()` and `leastCommonMultiple()` of BigInteger. They are here so all divisibility helpers live in one place.

## The extended Euclidean algorithm

`extendedGcd()` returns the gcd and two coefficients `x` and `y` such that `a * x + b * y = gcd`. This is Bezout's identity. The result is an immutable `ExtendedGcd` object with the public properties `gcd`, `x` and `y`.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Divisibility;

$a = new BigInteger(240);
$b = new BigInteger(46);

$bezout = Divisibility::extendedGcd($a, $b);

echo $bezout->gcd->value(); // 2
echo $bezout->x->value();   // -9
echo $bezout->y->value();   // 47
```

Here `240 * -9 + 46 * 47 = 2`. The coefficients are not unique. The library returns the pair that GMP computes.

## Checking the result

`satisfiesBezout()` checks that `a * x + b * y` equals the gcd. Pass the same inputs you gave to `extendedGcd()`.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Divisibility;

$a = new BigInteger(240);
$b = new BigInteger(46);

$bezout = Divisibility::extendedGcd($a, $b);

var_dump($bezout->satisfiesBezout($a, $b));                 // bool(true)
var_dump($bezout->satisfiesBezout($a, new BigInteger(47))); // bool(false)
```
