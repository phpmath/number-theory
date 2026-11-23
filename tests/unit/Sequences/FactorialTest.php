<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Sequences;

use PHPMath\NumberTheory\Exception\NegativeArgumentException;
use PHPMath\NumberTheory\Sequences;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Sequences::class)]
#[CoversMethod(Sequences::class, 'factorial')]
final class FactorialTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsFactorial(int $n, string $expected): void
    {
        // Arrange

        // Act
        $result = Sequences::factorial($n);

        // Assert
        self::assertSame($expected, $result->value());
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'zero' => [0, '1'],
            'one' => [1, '1'],
            'five' => [5, '120'],
            'twenty' => [20, '2432902008176640000'],
            'twenty five' => [25, '15511210043330985984000000'],
            'thirty' => [30, '265252859812191058636308480000000'],
        ];
    }

    public function testThrowsOnNegativeNumber(): void
    {
        // Arrange
        $this->expectException(NegativeArgumentException::class);

        // Act
        Sequences::factorial(-1);
    }
}
