<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Primality;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Primality;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Primality::class)]
#[CoversMethod(Primality::class, 'isExact')]
final class IsExactTest extends TestCase
{
    #[DataProvider('provideBelow')]
    public function testIsExactBelowBound(string $text): void
    {
        // Arrange
        $number = new BigInteger($text);

        // Act
        $result = Primality::isExact($number);

        // Assert
        self::assertTrue($result);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideBelow(): array
    {
        return [
            'small number' => ['97'],
            'negative number' => ['-5'],
            'just below the bound' => ['3317044064679887385961980'],
        ];
    }

    #[DataProvider('provideFrom')]
    public function testIsNotExactFromBound(string $text): void
    {
        // Arrange
        $number = new BigInteger($text);

        // Act
        $result = Primality::isExact($number);

        // Assert
        self::assertFalse($result);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideFrom(): array
    {
        return [
            'the bound itself' => ['3317044064679887385961981'],
            'mersenne 127' => ['170141183460469231731687303715884105727'],
        ];
    }

    public function testBoundConstantMatchesDocumentedValue(): void
    {
        // Arrange

        // Act
        $bound = Primality::DETERMINISTIC_BOUND;

        // Assert
        self::assertSame('3317044064679887385961981', $bound);
    }
}
