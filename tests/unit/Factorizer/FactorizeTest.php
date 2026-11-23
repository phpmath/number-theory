<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Factorizer;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\Factorizer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Factorizer::class)]
#[CoversMethod(Factorizer::class, 'factorize')]
final class FactorizeTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testFactorsNumber(string $text, string $expected): void
    {
        // Arrange
        $number = new BigInteger($text);

        // Act
        $factorization = Factorizer::factorize($number);

        // Assert
        self::assertSame($expected, (string)$factorization);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'one' => ['1', '1'],
            'two' => ['2', '2'],
            'power of two' => ['1024', '2^10'],
            'three hundred sixty' => ['360', '2^3 * 3^2 * 5'],
            'ten factorial' => ['3628800', '2^8 * 3^4 * 5^2 * 7'],
            'project euler three' => ['600851475143', '71 * 839 * 1471 * 6857'],
            'prime above trial division limit' => ['1000000007', '1000000007'],
            'fermat number f6' => ['18446744073709551617', '274177 * 67280421310721'],
            'mersenne 67 (cole)' => ['147573952589676412927', '193707721 * 761838257287'],
            'semiprime of two ten digit primes' => ['998244359987710471', '998244353 * 1000000007'],
            'square of a large prime' => ['1000000014000000049', '1000000007^2'],
            'cube of a large prime' => ['1000000021000000147000000343', '1000000007^3'],
            'mixed small and large factors' => ['12000000084', '2^2 * 3 * 1000000007'],
        ];
    }

    public function testFactorizationMultipliesBackToInput(): void
    {
        // Arrange
        $number = new BigInteger('600851475143');

        // Act
        $factorization = Factorizer::factorize($number);

        // Assert
        self::assertTrue($factorization->product()->equals($number));
    }

    public function testThrowsOnZero(): void
    {
        // Arrange
        $number = new BigInteger('0');
        $this->expectException(InvalidNumberException::class);

        // Act
        Factorizer::factorize($number);
    }

    public function testThrowsOnNegativeNumber(): void
    {
        // Arrange
        $number = new BigInteger('-12');
        $this->expectException(InvalidNumberException::class);

        // Act
        Factorizer::factorize($number);
    }
}
