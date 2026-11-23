<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\PrimeFactorization;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\PrimeFactorization;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(PrimeFactorization::class)]
#[CoversMethod(PrimeFactorization::class, 'exponentOf')]
final class ExponentOfTest extends TestCase
{
    public function testReturnsExponentOfFactor(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 3, 3 => 2, 5 => 1]);

        // Act
        $exponent = $factorization->exponentOf(new BigInteger('3'));

        // Assert
        self::assertSame(2, $exponent);
    }

    public function testReturnsZeroForNonFactor(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([2 => 3, 3 => 2, 5 => 1]);

        // Act
        $exponent = $factorization->exponentOf(new BigInteger('7'));

        // Assert
        self::assertSame(0, $exponent);
    }
}
