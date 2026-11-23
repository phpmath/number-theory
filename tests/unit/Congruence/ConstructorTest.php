<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Congruence;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Congruence;
use PHPMath\NumberTheory\Exception\InvalidModulusException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Congruence::class)]
#[CoversMethod(Congruence::class, '__construct')]
final class ConstructorTest extends TestCase
{
    public function testKeepsRemainderBelowModulus(): void
    {
        // Arrange

        // Act
        $congruence = new Congruence(new BigInteger('2'), new BigInteger('5'));

        // Assert
        self::assertSame('2', $congruence->remainder->value());
        self::assertSame('5', $congruence->modulus->value());
    }

    public function testNormalizesLargeRemainder(): void
    {
        // Arrange

        // Act
        $congruence = new Congruence(new BigInteger('17'), new BigInteger('5'));

        // Assert
        self::assertSame('2', $congruence->remainder->value());
    }

    public function testNormalizesNegativeRemainder(): void
    {
        // Arrange

        // Act
        $congruence = new Congruence(new BigInteger('-1'), new BigInteger('5'));

        // Assert
        self::assertSame('4', $congruence->remainder->value());
    }

    public function testThrowsOnZeroModulus(): void
    {
        // Arrange
        $this->expectException(InvalidModulusException::class);

        // Act
        new Congruence(new BigInteger('1'), new BigInteger('0'));
    }

    public function testThrowsOnNegativeModulus(): void
    {
        // Arrange
        $this->expectException(InvalidModulusException::class);

        // Act
        new Congruence(new BigInteger('1'), new BigInteger('-3'));
    }
}
