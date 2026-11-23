---
title: Modular arithmetic
intro: Powers and inverses modulo a number, congruences and the Chinese remainder theorem.
group: Guides
order: 40
---

## Powers modulo a number

`ModularArithmetic::powMod()` computes `base^exponent mod modulus` without ever building the huge intermediate power. The result is always in the range 0 up to the modulus. The modulus must be positive.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\ModularArithmetic;

$result = ModularArithmetic::powMod(new BigInteger(4), new BigInteger(13), new BigInteger(497));

echo $result->value(); // 445
```

A negative base still gives a result that is not negative. The exponent `0` gives `1`, except modulo 1 where everything is `0`.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\ModularArithmetic;

echo ModularArithmetic::powMod(new BigInteger(-2), new BigInteger(3), new BigInteger(7))->value(); // 6
echo ModularArithmetic::powMod(new BigInteger(0), new BigInteger(0), new BigInteger(7))->value();  // 1
echo ModularArithmetic::powMod(new BigInteger(2), new BigInteger(0), new BigInteger(1))->value();  // 0
```

## Negative exponents

A negative exponent raises the modular inverse of the base to the absolute value of the exponent. The next section explains the inverse. If the base has no inverse, `NotInvertibleException` is thrown.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\NotInvertibleException;
use PHPMath\NumberTheory\ModularArithmetic;

echo ModularArithmetic::powMod(new BigInteger(3), new BigInteger(-1), new BigInteger(11))->value(); // 4
echo ModularArithmetic::powMod(new BigInteger(3), new BigInteger(-2), new BigInteger(11))->value(); // 5

try {
    ModularArithmetic::powMod(new BigInteger(6), new BigInteger(-1), new BigInteger(9));
} catch (NotInvertibleException $exception) {
    echo $exception->getMessage(); // 6 has no inverse modulo 9 because they are not coprime.
}
```

## Modular inverse

The modular inverse of a value is the number `x` for which `value * x` leaves remainder 1 when divided by the modulus. It exists only when the value and the modulus are coprime. The result is in the range 0 up to the modulus. Modulo 1 every number is congruent to 0, so the result is `0` there.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\ModularArithmetic;

echo ModularArithmetic::inverse(new BigInteger(17), new BigInteger(3120))->value(); // 2753
echo ModularArithmetic::inverse(new BigInteger(-3), new BigInteger(11))->value();   // 7
echo ModularArithmetic::inverse(new BigInteger(5), new BigInteger(1))->value();     // 0
```

A non-positive modulus throws `InvalidModulusException`. A value that is not coprime with the modulus, including `0`, throws `NotInvertibleException`.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidModulusException;
use PHPMath\NumberTheory\Exception\NotInvertibleException;
use PHPMath\NumberTheory\ModularArithmetic;

try {
    ModularArithmetic::inverse(new BigInteger(5), new BigInteger(-3));
} catch (InvalidModulusException $exception) {
    echo $exception->getMessage(); // The modulus must be a positive integer, got -3.
}

try {
    ModularArithmetic::inverse(new BigInteger(0), new BigInteger(5));
} catch (NotInvertibleException $exception) {
    echo $exception->getMessage(); // 0 has no inverse modulo 5 because they are not coprime.
}
```

## Congruences

A `Congruence` says that `x` leaves a given remainder when divided by a given modulus. It is written `x = 2 (mod 3)`. The constructor takes any integer as remainder and normalizes it into the range 0 up to the modulus. The modulus must be positive. `isSatisfiedBy()` tests whether a number fits.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Congruence;

$congruence = new Congruence(new BigInteger(-1), new BigInteger(5));

echo $congruence;                                                   // x = 4 (mod 5)
var_dump($congruence->isSatisfiedBy(new BigInteger(14)));           // bool(true)
var_dump($congruence->isSatisfiedBy(new BigInteger(13)));           // bool(false)
```

## The Chinese remainder theorem

`ChineseRemainder::solve()` finds the number that satisfies several congruences at once. The answer is one congruence whose modulus is the lcm of all moduli. The moduli do not have to be coprime, as long as the system is consistent.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\ChineseRemainder;
use PHPMath\NumberTheory\Congruence;

$solution = ChineseRemainder::solve(
    new Congruence(new BigInteger(2), new BigInteger(3)),
    new Congruence(new BigInteger(3), new BigInteger(5)),
    new Congruence(new BigInteger(2), new BigInteger(7)),
);

echo $solution; // x = 23 (mod 105)
```

With moduli that share a factor, the system can still be solved.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\ChineseRemainder;
use PHPMath\NumberTheory\Congruence;

$solution = ChineseRemainder::solve(
    new Congruence(new BigInteger(2), new BigInteger(4)),
    new Congruence(new BigInteger(4), new BigInteger(6)),
);

echo $solution; // x = 10 (mod 12)
```

## When there is no solution

If two congruences contradict each other, `solve()` throws `UnsolvableCongruenceException`. Calling it with no congruence at all throws `EmptyCongruenceSystemException`. A single congruence is returned unchanged.

```php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\ChineseRemainder;
use PHPMath\NumberTheory\Congruence;
use PHPMath\NumberTheory\Exception\EmptyCongruenceSystemException;
use PHPMath\NumberTheory\Exception\UnsolvableCongruenceException;

try {
    ChineseRemainder::solve(
        new Congruence(new BigInteger(1), new BigInteger(4)),
        new Congruence(new BigInteger(2), new BigInteger(6)),
    );
} catch (UnsolvableCongruenceException $exception) {
    echo $exception->getMessage(); // The system of congruences has no solution.
}

try {
    ChineseRemainder::solve();
} catch (EmptyCongruenceSystemException $exception) {
    echo $exception->getMessage(); // At least one congruence is required.
}
```
