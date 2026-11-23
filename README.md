# number-theory

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]](LICENSE)
[![CI][ico-ci]][link-ci]
[![Total Downloads][ico-downloads]][link-downloads]

A PHP library with number theory algorithms for arbitrary-size integers. It is built on
[phpmath/biginteger](https://github.com/phpmath/biginteger) and the GMP extension.
All classes are either static function holders (`final class`, no instances) or immutable value objects
(`final readonly class`). Invalid input throws a specific exception from `PHPMath\NumberTheory\Exception`.

## Documentation

The full documentation is at https://phpmath.github.io/number-theory/. Every release is described on the [releases page](https://github.com/phpmath/number-theory/releases).

## Install

```bash
composer require phpmath/number-theory
```

## Requirements

- PHP 8.4 or newer
- The `gmp` extension
- `phpmath/biginteger`, which Composer installs for you

## Usage

``` php
use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Congruence;
use PHPMath\NumberTheory\ChineseRemainder;
use PHPMath\NumberTheory\Divisibility;
use PHPMath\NumberTheory\Factorizer;
use PHPMath\NumberTheory\ModularArithmetic;
use PHPMath\NumberTheory\Primality;
use PHPMath\NumberTheory\PrimeSieve;
use PHPMath\NumberTheory\Sequences;
use PHPMath\NumberTheory\Symbols;
use PHPMath\NumberTheory\Totient;

// Extended Euclidean algorithm: 240 * -9 + 46 * 47 = 2
$bezout = Divisibility::extendedGcd(new BigInteger(240), new BigInteger(46));
echo $bezout->gcd->value(), ' ', $bezout->x->value(), ' ', $bezout->y->value(); // 2 -9 47

// Chinese remainder theorem: x = 2 (mod 3), x = 3 (mod 5), x = 2 (mod 7)
$solution = ChineseRemainder::solve(
    new Congruence(new BigInteger(2), new BigInteger(3)),
    new Congruence(new BigInteger(3), new BigInteger(5)),
    new Congruence(new BigInteger(2), new BigInteger(7)),
);
echo $solution; // x = 23 (mod 105)

// Modular arithmetic
echo ModularArithmetic::powMod(new BigInteger(4), new BigInteger(13), new BigInteger(497))->value(); // 445
echo ModularArithmetic::inverse(new BigInteger(17), new BigInteger(3120))->value(); // 2753

// Primes
Primality::isPrime(new BigInteger('170141183460469231731687303715884105727')); // true
Primality::nextPrime(new BigInteger(100))->value(); // 101
Primality::previousPrime(new BigInteger(100))->value(); // 97
PrimeSieve::primesUpTo(30); // [2, 3, 5, 7, 11, 13, 17, 19, 23, 29]

// Factorization and the totient
$factorization = Factorizer::factorize(new BigInteger(360));
echo $factorization; // 2^3 * 3^2 * 5
$factorization->divisorCount(); // 24
Totient::of(new BigInteger(360))->value(); // 96

// Symbols and sequences
Symbols::jacobi(new BigInteger(1001), new BigInteger(9907)); // -1
Symbols::legendre(new BigInteger(5), new BigInteger(11)); // 1
Sequences::fibonacci(100)->value(); // 354224848179261915075
Sequences::factorial(25)->value(); // 15511210043330985984000000
```

## Features

| Class | Methods |
| --- | --- |
| `Divisibility` | `divides`, `isCoprime`, `gcd`, `lcm`, `extendedGcd` (returns an `ExtendedGcd`) |
| `ChineseRemainder` | `solve(Congruence ...$congruences)` returns a `Congruence`, moduli need not be coprime |
| `ModularArithmetic` | `powMod` (negative exponents allowed), `inverse` |
| `Primality` | `isPrime`, `isExact`, `nextPrime`, `previousPrime` |
| `PrimeSieve` | `primesUpTo(int $limit)` returns `list<int>` |
| `Factorizer` | `factorize` returns a `PrimeFactorization` |
| `PrimeFactorization` | `toArray`, `primes`, `exponentOf`, `product`, `divisors`, `divisorCount`, `totient`, `__toString` |
| `Totient` | `of` |
| `Symbols` | `jacobi`, `legendre` |
| `Sequences` | `fibonacci`, `factorial` |

### Primality testing

`Primality::isPrime()` is a Miller-Rabin test. Below 3317044064679887385961981 (about 3.3 * 10^24) it uses the
first 13 primes as witnesses, which is proven to be exact. From that bound on it uses the first 20 primes, which is
probabilistic: a composite number that is specially crafted against those witnesses could be reported as prime.
`Primality::isExact()` tells you which case applies to a number.

### Factorization

Factoring uses trial division by all primes up to 10,000, followed by Pollard's rho for what remains. It handles
numbers with small and medium prime factors quickly, but numbers that are the product of two large primes are slow:
as a rough guide, two close primes of 6, 10 and 12 digits each take about 0.01, 0.1 to 0.4 and 1 to 3 seconds, and the
time grows about ten times for every two extra digits, so two primes of 20 digits each would take hours.

### Overlap with BigInteger

`BigInteger` already offers `greatestCommonDivisor`, `leastCommonMultiple`, `invert`, `jacobi`, `legendre`,
`nextPrime`, `isPrimeNumber` and `factorial`. The matching helpers here are thin wrappers that add input validation
and specific exceptions (`Divisibility`, `ModularArithmetic::inverse`, `Symbols`, `Sequences::factorial`). Modular
exponentiation, the extended gcd, the primality test with a documented bound, `previousPrime`, sieving, factoring and
Fibonacci numbers are not in `BigInteger`.

## Development

```bash
composer test
composer test-coverage
composer analyse
composer check-style
composer fix-style
```

## Contributing

All contributions are welcome. Open an issue or a pull request on GitHub. Please follow the coding standard and add tests.

## Security

If you discover a security issue, please create an issue in the issue tracker.

## Credits

- [Walter Tamboer](https://github.com/waltertamboer)
- [All contributors](https://github.com/phpmath/number-theory/graphs/contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.

[ico-version]: https://img.shields.io/packagist/v/phpmath/number-theory.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-ci]: https://img.shields.io/github/actions/workflow/status/phpmath/number-theory/ci.yml?branch=master&style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/phpmath/number-theory.svg?style=flat-square

[link-packagist]: https://packagist.org/packages/phpmath/number-theory
[link-ci]: https://github.com/phpmath/number-theory/actions/workflows/ci.yml
[link-downloads]: https://packagist.org/packages/phpmath/number-theory/stats
