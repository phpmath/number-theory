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
#[CoversMethod(PrimeFactorization::class, 'product')]
final class ProductTest extends TestCase
{
    public function testMultipliesPrimePowers(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 3, 3 => 2, 5 => 1]);

        // Act
        $product = $factorization->product();

        // Assert
        self::assertSame('360', $product->value());
    }

    public function testProductOfEmptyFactorizationIsOne(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([]);

        // Act
        $product = $factorization->product();

        // Assert
        self::assertSame('1', $product->value());
    }

    public function testMultipliesBeyondNativeIntegers(): void
    {
        // Arrange
        $factorization = new PrimeFactorization(['618970019642690137449562111' => 2]);

        // Act
        $product = $factorization->product();

        // Assert
        self::assertSame('383123885216472214589586755549637256619304505646776321', $product->value());
    }
}
