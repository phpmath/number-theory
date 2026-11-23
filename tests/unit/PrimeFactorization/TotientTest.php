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
#[CoversMethod(PrimeFactorization::class, 'totient')]
final class TotientTest extends TestCase
{
    public function testComputesTotientOfThreeHundredSixty(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 3, 3 => 2, 5 => 1]);

        // Act
        $totient = $factorization->totient();

        // Assert
        self::assertSame('96', $totient->value());
    }

    public function testTotientOfOneIsOne(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([]);

        // Act
        $totient = $factorization->totient();

        // Assert
        self::assertSame('1', $totient->value());
    }
}
