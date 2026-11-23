<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\ModularArithmetic;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Exception\InvalidModulusException;
use PHPMath\NumberTheory\Exception\NotInvertibleException;
use PHPMath\NumberTheory\ModularArithmetic;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

#[CoversClass(ModularArithmetic::class)]
#[CoversMethod(ModularArithmetic::class, 'powMod')]
final class PowModTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testComputesModularPower(string $baseText, string $expText, string $modText, string $expected): void
    {
        // Arrange
        $base = new BigInteger($baseText);
        $exponent = new BigInteger($expText);
        $modulus = new BigInteger($modText);

        // Act
        $result = ModularArithmetic::powMod($base, $exponent, $modulus);

        // Assert
        self::assertSame($expected, $result->value());
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'textbook example' => ['4', '13', '497', '445'],
            'power of two' => ['2', '10', '1000', '24'],
            'zero exponent' => ['7', '0', '13', '1'],
            'modulus one' => ['7', '5', '1', '0'],
            'negative base' => ['-2', '3', '5', '2'],
            'negative exponent uses inverse' => ['3', '-1', '11', '4'],
            'fermat little theorem' => ['2', '1000000006', '1000000007', '1'],
            'mersenne prime modulus' => ['3', '2305843009213693950', '2305843009213693951', '1'],
        ];
    }

    public function testThrowsOnZeroModulus(): void
    {
        // Arrange
        $this->expectException(InvalidModulusException::class);

        // Act
        ModularArithmetic::powMod(new BigInteger('2'), new BigInteger('3'), new BigInteger('0'));
    }

    public function testThrowsOnNegativeModulus(): void
    {
        // Arrange
        $this->expectException(InvalidModulusException::class);

        // Act
        ModularArithmetic::powMod(new BigInteger('2'), new BigInteger('3'), new BigInteger('-5'));
    }

    public function testThrowsWhenNegativeExponentHasNoInverse(): void
    {
        // Arrange
        $this->expectException(NotInvertibleException::class);

        // Act
        ModularArithmetic::powMod(new BigInteger('2'), new BigInteger('-1'), new BigInteger('4'));
    }
}
