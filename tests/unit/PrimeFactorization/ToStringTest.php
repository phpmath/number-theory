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
#[CoversMethod(PrimeFactorization::class, '__toString')]
final class ToStringTest extends TestCase
{
    public function testFormatsPrimePowers(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 3, 5 => 1]);

        // Act
        $text = (string)$factorization;

        // Assert
        self::assertSame('2^3 * 5', $text);
    }

    public function testFormatsSinglePrime(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([7 => 1]);

        // Act
        $text = (string)$factorization;

        // Assert
        self::assertSame('7', $text);
    }

    public function testFormatsMultiplePowers(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 3, 3 => 2, 5 => 1]);

        // Act
        $text = (string)$factorization;

        // Assert
        self::assertSame('2^3 * 3^2 * 5', $text);
    }

    public function testFormatsOneAsOne(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([]);

        // Act
        $text = (string)$factorization;

        // Assert
        self::assertSame('1', $text);
    }
}
