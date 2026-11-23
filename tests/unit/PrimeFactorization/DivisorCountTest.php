<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\PrimeFactorization;

use PHPMath\NumberTheory\PrimeFactorization;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(PrimeFactorization::class)]
#[CoversMethod(PrimeFactorization::class, 'divisorCount')]
final class DivisorCountTest extends TestCase
{
    public function testCountsDivisorsOfThreeHundredSixty(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 3, 3 => 2, 5 => 1]);

        // Act
        $count = $factorization->divisorCount();

        // Assert
        self::assertSame(24, $count);
    }

    public function testOneHasOneDivisor(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([]);

        // Act
        $count = $factorization->divisorCount();

        // Assert
        self::assertSame(1, $count);
    }
}
