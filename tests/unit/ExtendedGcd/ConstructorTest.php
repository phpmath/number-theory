<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\ExtendedGcd;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\ExtendedGcd;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(ExtendedGcd::class)]
#[CoversMethod(ExtendedGcd::class, '__construct')]
final class ConstructorTest extends TestCase
{
    public function testExposesValues(): void
    {
        // Arrange
        $gcd = new BigInteger('2');
        $x = new BigInteger('-9');
        $y = new BigInteger('47');

        // Act
        $result = new ExtendedGcd($gcd, $x, $y);

        // Assert
        self::assertSame($gcd, $result->gcd);
        self::assertSame($x, $result->x);
        self::assertSame($y, $result->y);
    }
}
