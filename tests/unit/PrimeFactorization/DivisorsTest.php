<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\PrimeFactorization;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\PrimeFactorization;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

use function array_map;

#[CoversClass(PrimeFactorization::class)]
#[CoversMethod(PrimeFactorization::class, 'divisors')]
final class DivisorsTest extends TestCase
{
    public function testListsDivisorsOfTwelve(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 2, 3 => 1]);

        // Act
        $divisors = $factorization->divisors();

        // Assert
        self::assertSame(
            ['1', '2', '3', '4', '6', '12'],
            array_map(static fn (BigInteger $divisor): string => $divisor->value(), $divisors),
        );
    }

    public function testOneHasOnlyOneAsDivisor(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([]);

        // Act
        $divisors = $factorization->divisors();

        // Assert
        self::assertSame(['1'], array_map(static fn (BigInteger $divisor): string => $divisor->value(), $divisors));
    }

    public function testListsAllDivisorsOfThreeHundredSixty(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 3, 3 => 2, 5 => 1]);

        // Act
        $divisors = $factorization->divisors();

        // Assert
        self::assertSame(
            [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '8',
                '9',
                '10',
                '12',
                '15',
                '18',
                '20',
                '24',
                '30',
                '36',
                '40',
                '45',
                '60',
                '72',
                '90',
                '120',
                '180',
                '360',
            ],
            array_map(static fn (BigInteger $divisor): string => $divisor->value(), $divisors),
        );
    }
}
