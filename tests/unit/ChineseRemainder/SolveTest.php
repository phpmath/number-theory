<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\ChineseRemainder;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\ChineseRemainder;
use PHPMath\NumberTheory\Congruence;
use PHPMath\NumberTheory\Exception\EmptyCongruenceSystemException;
use PHPMath\NumberTheory\Exception\UnsolvableCongruenceException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(ChineseRemainder::class)]
#[CoversMethod(ChineseRemainder::class, 'solve')]
final class SolveTest extends TestCase
{
    public function testSolvesSunTzuProblem(): void
    {
        // Arrange

        // Act
        $solution = ChineseRemainder::solve(
            new Congruence(new BigInteger('2'), new BigInteger('3')),
            new Congruence(new BigInteger('3'), new BigInteger('5')),
            new Congruence(new BigInteger('2'), new BigInteger('7')),
        );

        // Assert
        self::assertSame('23', $solution->remainder->value());
        self::assertSame('105', $solution->modulus->value());
    }

    public function testSolvesCoprimeTextbookSystem(): void
    {
        // Arrange

        // Act
        $solution = ChineseRemainder::solve(
            new Congruence(new BigInteger('0'), new BigInteger('3')),
            new Congruence(new BigInteger('3'), new BigInteger('4')),
            new Congruence(new BigInteger('4'), new BigInteger('5')),
        );

        // Assert
        self::assertSame('39', $solution->remainder->value());
        self::assertSame('60', $solution->modulus->value());
    }

    public function testSolvesSystemWithRemaindersOneFiveFour(): void
    {
        // Arrange

        // Act
        $solution = ChineseRemainder::solve(
            new Congruence(new BigInteger('1'), new BigInteger('5')),
            new Congruence(new BigInteger('5'), new BigInteger('6')),
            new Congruence(new BigInteger('4'), new BigInteger('7')),
        );

        // Assert
        self::assertSame('11', $solution->remainder->value());
        self::assertSame('210', $solution->modulus->value());
    }

    public function testSolvesSystemWithCommonFactorsInModuli(): void
    {
        // Arrange

        // Act
        $solution = ChineseRemainder::solve(
            new Congruence(new BigInteger('2'), new BigInteger('6')),
            new Congruence(new BigInteger('8'), new BigInteger('10')),
        );

        // Assert
        self::assertSame('8', $solution->remainder->value());
        self::assertSame('30', $solution->modulus->value());
    }

    public function testSolvesWithModuliBeyondNativeIntegers(): void
    {
        // Arrange

        // Act
        $solution = ChineseRemainder::solve(
            new Congruence(new BigInteger('1'), new BigInteger('1000000007')),
            new Congruence(new BigInteger('2'), new BigInteger('998244353')),
        );

        // Assert
        self::assertSame('998244359987710471', $solution->modulus->value());
        self::assertSame('1', $solution->remainder->mod(new BigInteger('1000000007'))->value());
        self::assertSame('2', $solution->remainder->mod(new BigInteger('998244353'))->value());
    }

    public function testReturnsSingleCongruenceUnchanged(): void
    {
        // Arrange
        $congruence = new Congruence(new BigInteger('3'), new BigInteger('7'));

        // Act
        $solution = ChineseRemainder::solve($congruence);

        // Assert
        self::assertSame($congruence, $solution);
    }

    public function testThrowsOnInconsistentSystem(): void
    {
        // Arrange
        $this->expectException(UnsolvableCongruenceException::class);

        // Act
        ChineseRemainder::solve(
            new Congruence(new BigInteger('1'), new BigInteger('4')),
            new Congruence(new BigInteger('2'), new BigInteger('6')),
        );
    }

    public function testThrowsOnContradictingParity(): void
    {
        // Arrange
        $this->expectException(UnsolvableCongruenceException::class);

        // Act
        ChineseRemainder::solve(
            new Congruence(new BigInteger('1'), new BigInteger('2')),
            new Congruence(new BigInteger('0'), new BigInteger('4')),
        );
    }

    public function testThrowsOnEmptySystem(): void
    {
        // Arrange
        $this->expectException(EmptyCongruenceSystemException::class);

        // Act
        ChineseRemainder::solve();
    }
}
