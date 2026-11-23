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
#[CoversMethod(Divisibility::class, 'divides')]
final class DividesTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReportsDivisibility(string $divisorText, string $valueText, bool $expected): void
    {
        // Arrange
        $divisor = new BigInteger($divisorText);
        $value = new BigInteger($valueText);

        // Act
        $result = Divisibility::divides($divisor, $value);

        // Assert
        self::assertSame($expected, $result);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'divisor divides value' => ['3', '12', true],
            'divisor does not divide value' => ['5', '12', false],
            'negative divisor' => ['-3', '12', true],
            'negative value' => ['4', '-12', true],
            'zero divides zero' => ['0', '0', true],
            'zero does not divide non-zero' => ['0', '5', false],
            'everything divides zero' => ['7', '0', true],
            'beyond native integers' => ['1000000007', '1000000014000000049', true],
        ];
    }
}
