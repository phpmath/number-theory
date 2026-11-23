<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\ExtendedGcd;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\ExtendedGcd;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExtendedGcd::class)]
#[CoversMethod(ExtendedGcd::class, 'satisfiesBezout')]
final class SatisfiesBezoutTest extends TestCase
{
    public function testReturnsTrueForValidCoefficients(): void
    {
        // Arrange
        $result = new ExtendedGcd(new BigInteger('2'), new BigInteger('-9'), new BigInteger('47'));

        // Act
        $satisfies = $result->satisfiesBezout(new BigInteger('240'), new BigInteger('46'));

        // Assert
        self::assertTrue($satisfies);
    }

    public function testReturnsFalseForWrongCoefficients(): void
    {
        // Arrange
        $result = new ExtendedGcd(new BigInteger('2'), new BigInteger('-8'), new BigInteger('47'));

        // Act
        $satisfies = $result->satisfiesBezout(new BigInteger('240'), new BigInteger('46'));

        // Assert
        self::assertFalse($satisfies);
    }
}
