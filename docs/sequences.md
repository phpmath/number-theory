---
title: Sequences
intro: Fibonacci numbers and factorials of any size.
group: Guides
order: 80
---

## Fibonacci numbers

The Fibonacci sequence starts with 0 and 1, and every next number is the sum of the previous two. `Sequences::fibonacci()` takes the index as a plain `int` and returns the number as a `BigInteger`. It uses fast doubling, so it needs only a handful of multiplications even for a large index.

```php
use PHPMath\NumberTheory\Sequences;

echo Sequences::fibonacci(0)->value();    // 0
echo Sequences::fibonacci(1)->value();    // 1
echo Sequences::fibonacci(10)->value();   // 55
echo Sequences::fibonacci(100)->value();  // 354224848179261915075
```

A negative index throws `NegativeArgumentException`.

```php
use PHPMath\NumberTheory\Exception\NegativeArgumentException;
use PHPMath\NumberTheory\Sequences;

try {
    Sequences::fibonacci(-1);
} catch (NegativeArgumentException $exception) {
    echo $exception->getMessage(); // The argument "n" must not be negative, got -1.
}
```

> [!NOTE]
> The result has about 0.2 digits for every step of the index, so a very large index needs a very large amount of memory. The library does not cap the index.

## Factorials

The factorial `n!` is the product of all whole numbers from 1 up to n, and `0!` is 1. `Sequences::factorial()` takes a plain `int` and returns a `BigInteger`. It uses `factorial()` of BigInteger after checking the argument.

```php
use PHPMath\NumberTheory\Sequences;

echo Sequences::factorial(0)->value();   // 1
echo Sequences::factorial(5)->value();   // 120
echo Sequences::factorial(25)->value();  // 15511210043330985984000000
echo Sequences::factorial(30)->value();  // 265252859812191058636308480000000
```

A negative argument throws `NegativeArgumentException`, just like `fibonacci()`.
