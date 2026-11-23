<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Primality;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\Primality;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(Primality::class)]
#[CoversMethod(Primality::class, 'previousPrime')]
final class PreviousPrimeTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsPreviousPrime(string $text, string $expected): void
    {
        // Arrange
        $number = new BigInteger($text);

        // Act
        $result = Primality::previousPrime($number);

        // Assert
        self::assertSame($expected, $result->value());
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'three' => ['3', '2'],
            'four' => ['4', '3'],
            'composite' => ['100', '97'],
            'prime' => ['13', '11'],
            'thousand and first prime' => ['7927', '7919'],
            'billion and seven' => ['1000000007', '999999937'],
        ];
    }

    public function testThrowsForTwo(): void
    {
        // Arrange
        $number = new BigInteger('2');
        $this->expectException(InvalidNumberException::class);

        // Act
        Primality::previousPrime($number);
    }

    public function testThrowsForNegativeNumber(): void
    {
        // Arrange
        $number = new BigInteger('-10');
        $this->expectException(InvalidNumberException::class);

        // Act
        Primality::previousPrime($number);
    }
}
