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
#[CoversMethod(ModularArithmetic::class, 'inverse')]
final class InverseTest extends TestCase
{
    #[DataProvider('provideCases')]
    public function testComputesInverse(string $valueText, string $modulusText, string $expected): void
    {
        // Arrange
        $value = new BigInteger($valueText);
        $modulus = new BigInteger($modulusText);

        // Act
        $result = ModularArithmetic::inverse($value, $modulus);

        // Assert
        self::assertSame($expected, $result->value());
    }

    /** @return array<string, array<int, mixed>> */
    public static function provideCases(): array
    {
        return [
            'small example' => ['3', '11', '4'],
            'rsa textbook example' => ['17', '3120', '2753'],
            'negative value' => ['-3', '11', '7'],
            'modulus one' => ['5', '1', '0'],
        ];
    }

    public function testThrowsWhenNotCoprime(): void
    {
        // Arrange
        $this->expectException(NotInvertibleException::class);

        // Act
        ModularArithmetic::inverse(new BigInteger('6'), new BigInteger('9'));
    }

    public function testThrowsOnZeroModulus(): void
    {
        // Arrange
        $this->expectException(InvalidModulusException::class);

        // Act
        ModularArithmetic::inverse(new BigInteger('6'), new BigInteger('0'));
    }

    public function testThrowsOnNegativeModulus(): void
    {
        // Arrange
        $this->expectException(InvalidModulusException::class);

        // Act
        ModularArithmetic::inverse(new BigInteger('6'), new BigInteger('-7'));
    }
}
