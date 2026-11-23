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
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(Congruence::class)]
#[CoversMethod(Congruence::class, 'isSatisfiedBy')]
final class IsSatisfiedByTest extends TestCase
{
    public function testReturnsTrueForMatchingNumber(): void
    {
        // Arrange
        $congruence = new Congruence(new BigInteger('2'), new BigInteger('3'));

        // Act
        $result = $congruence->isSatisfiedBy(new BigInteger('23'));

        // Assert
        self::assertTrue($result);
    }

    public function testReturnsTrueForNegativeMatchingNumber(): void
    {
        // Arrange
        $congruence = new Congruence(new BigInteger('2'), new BigInteger('3'));

        // Act
        $result = $congruence->isSatisfiedBy(new BigInteger('-1'));

        // Assert
        self::assertTrue($result);
    }

    public function testReturnsFalseForOtherNumber(): void
    {
        // Arrange
        $congruence = new Congruence(new BigInteger('2'), new BigInteger('3'));

        // Act
        $result = $congruence->isSatisfiedBy(new BigInteger('24'));

        // Assert
        self::assertFalse($result);
    }
}
