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
#[CoversMethod(Primality::class, 'nextPrime')]
final class NextPrimeTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testReturnsNextPrime(string $text, string $expected): void
    {
        // Arrange
        $number = new BigInteger($text);

        // Act
        $result = Primality::nextPrime($number);

        // Assert
        self::assertSame($expected, $result->value());
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'negative number' => ['-5', '2'],
            'zero' => ['0', '2'],
            'one' => ['1', '2'],
            'two' => ['2', '3'],
            'three' => ['3', '5'],
            'composite' => ['100', '101'],
            'prime' => ['13', '17'],
            'thousandth prime' => ['7919', '7927'],
            'one billion' => ['1000000000', '1000000007'],
        ];
    }
}
