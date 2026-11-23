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
#[CoversMethod(Divisibility::class, 'lcm')]
final class LcmTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsLeastCommonMultiple(string $aText, string $bText, string $expected): void
    {
        // Arrange
        $a = new BigInteger($aText);
        $b = new BigInteger($bText);

        // Act
        $result = Divisibility::lcm($a, $b);

        // Assert
        self::assertSame($expected, $result->value());
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'textbook example' => ['4', '6', '12'],
            'coprime numbers' => ['7', '13', '91'],
            'negative input' => ['-4', '6', '12'],
            'with zero' => ['0', '6', '0'],
        ];
    }
}
