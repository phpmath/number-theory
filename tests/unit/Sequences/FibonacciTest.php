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
#[CoversMethod(Sequences::class, 'fibonacci')]
final class FibonacciTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsFibonacciNumber(int $n, string $expected): void
    {
        // Arrange

        // Act
        $result = Sequences::fibonacci($n);

        // Assert
        self::assertSame($expected, $result->value());
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'zero' => [0, '0'],
            'one' => [1, '1'],
            'two' => [2, '1'],
            'ten' => [10, '55'],
            'twenty' => [20, '6765'],
            'fifty' => [50, '12586269025'],
            'ninety' => [90, '2880067194370816120'],
            'hundred' => [100, '354224848179261915075'],
            'three hundred' => [300, '222232244629420445529739893461909967206666939096499764990979600'],
        ];
    }

    public function testThrowsOnNegativeIndex(): void
    {
        // Arrange
        $this->expectException(NegativeArgumentException::class);

        // Act
        Sequences::fibonacci(-1);
    }
}
