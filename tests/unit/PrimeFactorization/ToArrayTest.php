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
#[CoversMethod(PrimeFactorization::class, 'toArray')]
final class ToArrayTest extends TestCase
{
    public function testReturnsMapOfPrimesToExponents(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 3, 3 => 2, 5 => 1]);

        // Act
        $map = $factorization->toArray();

        // Assert
        self::assertSame([2 => 3, 3 => 2, 5 => 1], $map);
    }

    public function testReturnsEmptyMapForOne(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([]);

        // Act
        $map = $factorization->toArray();

        // Assert
        self::assertSame([], $map);
    }
}
