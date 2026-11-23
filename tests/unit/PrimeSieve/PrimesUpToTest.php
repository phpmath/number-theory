<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\PrimeSieve;

use PHPMath\NumberTheory\Exception\LimitTooLargeException;
use PHPMath\NumberTheory\Exception\NegativeArgumentException;
use PHPMath\NumberTheory\PrimeSieve;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

use const PHP_INT_MAX;
use const PHP_INT_MIN;

#[CoversClass(PrimeSieve::class)]
#[CoversMethod(PrimeSieve::class, 'primesUpTo')]
final class PrimesUpToTest extends TestCase
{
    public function testReturnsPrimesUpToThirty(): void
    {
        // Arrange

        // Act
        $primes = PrimeSieve::primesUpTo(30);

        // Assert
        self::assertSame([2, 3, 5, 7, 11, 13, 17, 19, 23, 29], $primes);
    }

    public function testIncludesLimitWhenPrime(): void
    {
        // Arrange

        // Act
        $primes = PrimeSieve::primesUpTo(29);

        // Assert
        self::assertSame(29, $primes[9]);
        self::assertCount(10, $primes);
    }

    #[DataProvider('provideBelowTwo')]
    public function testReturnsEmptyListBelowTwo(int $limitValue): void
    {
        // Arrange
        $limit = $limitValue;

        // Act
        $primes = PrimeSieve::primesUpTo($limit);

        // Assert
        self::assertSame([], $primes);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideBelowTwo(): array
    {
        return [
            'zero' => [0],
            'one' => [1],
        ];
    }

    public function testReturnsTwoForLimitTwo(): void
    {
        // Arrange

        // Act
        $primes = PrimeSieve::primesUpTo(2);

        // Assert
        self::assertSame([2], $primes);
    }

    #[DataProvider('provideCounts')]
    public function testCountsPrimes(int $limit, int $expected): void
    {
        // Arrange

        // Act
        $primes = PrimeSieve::primesUpTo($limit);

        // Assert
        self::assertCount($expected, $primes);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCounts(): array
    {
        return [
            'up to 100' => [100, 25],
            'up to 1000' => [1000, 168],
            'up to 10000' => [10000, 1229],
            'up to 1000000' => [1000000, 78498],
        ];
    }

    public function testLastPrimeBelowHundredIsNinetySeven(): void
    {
        // Arrange

        // Act
        $primes = PrimeSieve::primesUpTo(100);

        // Assert
        self::assertSame(97, $primes[24]);
    }

    public function testThrowsOnNegativeLimit(): void
    {
        // Arrange
        $this->expectException(NegativeArgumentException::class);

        // Act
        PrimeSieve::primesUpTo(-1);
    }

    public function testThrowsOnMostNegativeLimit(): void
    {
        // Arrange
        $this->expectException(NegativeArgumentException::class);

        // Act
        PrimeSieve::primesUpTo(PHP_INT_MIN);
    }

    public function testThrowsOnLimitAboveMaximum(): void
    {
        // Arrange
        $this->expectException(LimitTooLargeException::class);
        $this->expectExceptionMessage('The limit must not be greater than 10000000, got 10000001.');

        // Act
        PrimeSieve::primesUpTo(PrimeSieve::MAX_LIMIT + 1);
    }

    public function testThrowsOnIntMaxLimit(): void
    {
        // Arrange
        $this->expectException(LimitTooLargeException::class);

        // Act
        PrimeSieve::primesUpTo(PHP_INT_MAX);
    }

    public function testAcceptsMaximumLimit(): void
    {
        // Arrange

        // Act
        $primes = PrimeSieve::primesUpTo(PrimeSieve::MAX_LIMIT);

        // Assert
        self::assertCount(664579, $primes);
    }
}
