<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Divisibility;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Divisibility;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Divisibility::class)]
#[CoversMethod(Divisibility::class, 'extendedGcd')]
final class ExtendedGcdTest extends TestCase
{
    public function testReturnsTextbookCoefficients(): void
    {
        // Arrange
        $a = new BigInteger('240');
        $b = new BigInteger('46');

        // Act
        $result = Divisibility::extendedGcd($a, $b);

        // Assert
        self::assertSame('2', $result->gcd->value());
        self::assertSame('-9', $result->x->value());
        self::assertSame('47', $result->y->value());
    }

    public function testCoefficientsSatisfyBezoutForLargeNumbers(): void
    {
        // Arrange
        $a = new BigInteger('123456789012345678901234567890');
        $b = new BigInteger('987654321098765432109876543210');

        // Act
        $result = Divisibility::extendedGcd($a, $b);

        // Assert
        self::assertSame('9000000000900000000090', $result->gcd->value());
        self::assertTrue($result->satisfiesBezout($a, $b));
    }

    public function testHandlesNegativeInput(): void
    {
        // Arrange
        $a = new BigInteger('-12');
        $b = new BigInteger('18');

        // Act
        $result = Divisibility::extendedGcd($a, $b);

        // Assert
        self::assertSame('6', $result->gcd->value());
        self::assertTrue($result->satisfiesBezout($a, $b));
    }
}
