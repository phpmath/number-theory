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
#[CoversMethod(Congruence::class, '__toString')]
final class ToStringTest extends TestCase
{
    public function testFormatsCongruence(): void
    {
        // Arrange
        $congruence = new Congruence(new BigInteger('2'), new BigInteger('3'));

        // Act
        $text = (string)$congruence;

        // Assert
        self::assertSame('x = 2 (mod 3)', $text);
    }
}
