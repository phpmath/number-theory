<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\PrimeFactorization;

use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\PrimeFactorization;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(PrimeFactorization::class)]
#[CoversMethod(PrimeFactorization::class, '__construct')]
final class ConstructorTest extends TestCase
{
    public function testSortsPrimesAscending(): void
    {
        // Arrange

        // Act
        $factorization = new PrimeFactorization([5 => 1, 2 => 3]);

        // Assert
        self::assertSame([2 => 3, 5 => 1], $factorization->toArray());
    }

    public function testAcceptsDecimalStringKeysBeyondNativeIntegers(): void
    {
        // Arrange

        // Act
        $factorization = new PrimeFactorization(['618970019642690137449562111' => 2]);

        // Assert
        self::assertSame(['618970019642690137449562111' => 2], $factorization->toArray());
    }

    public function testThrowsWhenKeyIsNotPrime(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        new PrimeFactorization([4 => 1]);
    }

    public function testThrowsWhenKeyIsNotNumeric(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        new PrimeFactorization(['abc' => 1]);
    }

    public function testThrowsWhenKeyIsNegative(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        new PrimeFactorization([-3 => 1]);
    }

    public function testThrowsWhenExponentIsZero(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        new PrimeFactorization([2 => 0]);
    }
}
