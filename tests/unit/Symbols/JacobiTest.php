<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Symbols;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\Symbols;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Symbols::class)]
#[CoversMethod(Symbols::class, 'jacobi')]
final class JacobiTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testComputesJacobiSymbol(string $aText, string $nText, int $expected): void
    {
        // Arrange
        $a = new BigInteger($aText);
        $n = new BigInteger($nText);

        // Act
        $result = Symbols::jacobi($a, $n);

        // Assert
        self::assertSame($expected, $result);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'residue modulo seven' => ['2', '7', 1],
            'non residue modulo seven' => ['3', '7', -1],
            'divisible' => ['7', '7', 0],
            'composite denominator' => ['5', '21', 1],
            'wikipedia example' => ['1001', '9907', -1],
            'negative numerator' => ['-1', '7', -1],
            'denominator one' => ['12', '1', 1],
        ];
    }

    public function testThrowsOnEvenDenominator(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        Symbols::jacobi(new BigInteger('3'), new BigInteger('8'));
    }

    public function testThrowsOnZeroDenominator(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        Symbols::jacobi(new BigInteger('3'), new BigInteger('0'));
    }

    public function testThrowsOnNegativeDenominator(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        Symbols::jacobi(new BigInteger('3'), new BigInteger('-7'));
    }
}
