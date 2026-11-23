<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Divisibility;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Divisibility;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Divisibility::class)]
#[CoversMethod(Divisibility::class, 'isCoprime')]
final class IsCoprimeTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReportsCoprimality(string $aText, string $bText, bool $expected): void
    {
        // Arrange
        $a = new BigInteger($aText);
        $b = new BigInteger($bText);

        // Act
        $result = Divisibility::isCoprime($a, $b);

        // Assert
        self::assertSame($expected, $result);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'coprime composites' => ['8', '15', true],
            'common factor' => ['12', '18', false],
            'consecutive numbers' => ['1000000007', '1000000008', true],
            'one and zero' => ['1', '0', true],
            'zero and zero' => ['0', '0', false],
        ];
    }
}
