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
#[CoversMethod(PrimeFactorization::class, 'primes')]
final class PrimesTest extends TestCase
{
    public function testReturnsDistinctPrimesAscending(): void
    {
        // Arrange
        $factorization = new PrimeFactorization([5 => 1, 2 => 3]);

        // Act
        $primes = $factorization->primes();

        // Assert
        self::assertSame(['2', '5'], [$primes[0]->value(), $primes[1]->value()]);
        self::assertCount(2, $primes);
    }
}
