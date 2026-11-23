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
#[CoversMethod(Divisibility::class, 'gcd')]
final class GcdTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsGreatestCommonDivisor(string $aText, string $bText, string $expected): void
    {
        // Arrange
        $a = new BigInteger($aText);
        $b = new BigInteger($bText);

        // Act
        $result = Divisibility::gcd($a, $b);

        // Assert
        self::assertSame($expected, $result->value());
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'textbook example' => ['48', '18', '6'],
            'negative input' => ['-48', '18', '6'],
            'with zero' => ['0', '9', '9'],
            'large numbers' => ['1000000014000000049', '1000000007', '1000000007'],
        ];
    }
}
