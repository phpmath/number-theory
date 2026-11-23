<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Totient;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\Totient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Totient::class)]
#[CoversMethod(Totient::class, 'of')]
final class OfTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testComputesTotient(string $text, string $expected): void
    {
        // Arrange
        $number = new BigInteger($text);

        // Act
        $totient = Totient::of($number);

        // Assert
        self::assertSame($expected, $totient->value());
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'one' => ['1', '1'],
            'prime' => ['97', '96'],
            'prime square' => ['9', '6'],
            'two times five' => ['10', '4'],
            'thirty six' => ['36', '12'],
            'power of two' => ['1024', '512'],
            'large prime' => ['1000000007', '1000000006'],
            'project euler three number' => ['600851475143', '591194251200'],
        ];
    }

    public function testThrowsOnZero(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        Totient::of(new BigInteger('0'));
    }

    public function testThrowsOnNegativeNumber(): void
    {
        // Arrange
        $this->expectException(InvalidNumberException::class);

        // Act
        Totient::of(new BigInteger('-4'));
    }
}
