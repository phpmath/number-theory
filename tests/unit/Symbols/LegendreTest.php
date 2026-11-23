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
#[CoversMethod(Symbols::class, 'legendre')]
final class LegendreTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testComputesLegendreSymbol(string $aText, string $pText, int $expected): void
    {
        // Arrange
        $a = new BigInteger($aText);
        $p = new BigInteger($pText);

        // Act
        $result = Symbols::legendre($a, $p);

        // Assert
        self::assertSame($expected, $result);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'residue' => ['5', '11', 1],
            'another residue' => ['3', '11', 1],
            'non residue' => ['2', '11', -1],
            'divisible' => ['11', '11', 0],
            'negative non residue' => ['-1', '11', -1],
            'large prime' => ['2', '1000000007', 1],
        ];
    }

    public function testThrowsOnCompositeDenominator(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        Symbols::legendre(new BigInteger('2'), new BigInteger('15'));
    }

    public function testThrowsOnTwo(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        Symbols::legendre(new BigInteger('1'), new BigInteger('2'));
    }

    public function testThrowsOnOne(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        Symbols::legendre(new BigInteger('1'), new BigInteger('1'));
    }
}
