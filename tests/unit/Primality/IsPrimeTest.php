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
#[CoversMethod(Primality::class, 'isPrime')]
final class IsPrimeTest extends TestCase
{
    #[DataProvider('providePrimes')]
    public function testAcceptsPrimes(string $text): void
    {
        // Arrange
        $number = new BigInteger($text);

        // Act
        $result = Primality::isPrime($number);

        // Assert
        self::assertTrue($result);
    }

    /** @return array<string, array<int, mixed>> */
    public static function providePrimes(): array
    {
        return [
            'two' => ['2'],
            'three' => ['3'],
            'ninety seven' => ['97'],
            'thousandth prime' => ['7919'],
            'billion and seven' => ['1000000007'],
            'mersenne 31' => ['2147483647'],
            'mersenne 61' => ['2305843009213693951'],
            'mersenne 89' => ['618970019642690137449562111'],
            'mersenne 127' => ['170141183460469231731687303715884105727'],
        ];
    }

    #[DataProvider('provideComposites')]
    public function testRejectsComposites(string $text): void
    {
        // Arrange
        $number = new BigInteger($text);

        // Act
        $result = Primality::isPrime($number);

        // Assert
        self::assertFalse($result);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideComposites(): array
    {
        return [
            'four' => ['4'],
            '561 carmichael' => ['561'],
            '1105 carmichael' => ['1105'],
            '1729 carmichael' => ['1729'],
            '2465 carmichael' => ['2465'],
            '41041 carmichael' => ['41041'],
            '825265 carmichael' => ['825265'],
            'strong pseudoprime to bases 2 3 5 7 11' => ['2152302898747'],
            'strong pseudoprime to bases up to 13' => ['3474749660383'],
            'strong pseudoprime to bases up to 17' => ['341550071728321'],
            'strong pseudoprime to bases up to 23' => ['3825123056546413051'],
            'mersenne 67 is composite' => ['147573952589676412927'],
            'product of two mersenne primes' => ['1427247692705959880439315947500961989719490561'],
            'smallest strong pseudoprime to the first 13 primes' => ['3317044064679887385961981'],
            'square of a large prime' => ['1000000014000000049'],
        ];
    }

    #[DataProvider('provideBelowTwo')]
    public function testRejectsNumbersBelowTwo(string $text): void
    {
        // Arrange
        $number = new BigInteger($text);

        // Act
        $result = Primality::isPrime($number);

        // Assert
        self::assertFalse($result);
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideBelowTwo(): array
    {
        return [
            'negative prime magnitude' => ['-7'],
            'minus one' => ['-1'],
            'zero' => ['0'],
            'one' => ['1'],
        ];
    }
}
