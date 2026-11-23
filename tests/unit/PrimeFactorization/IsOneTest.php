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
#[CoversMethod(PrimeFactorization::class, 'isOne')]
final class IsOneTest extends TestCase
{
    public function testEmptyFactorizationIsOne(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([]);

        // Act
        $result = $factorization->isOne();

        // Assert
        self::assertTrue($result);
    }

    public function testNonEmptyFactorizationIsNotOne(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 1]);

        // Act
        $result = $factorization->isOne();

        // Assert
        self::assertFalse($result);
    }
}
