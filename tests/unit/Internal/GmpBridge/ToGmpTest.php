<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Internal\GmpBridge;

use PHPMath\BigInteger\BigInteger;
use PHPMath\NumberTheory\Internal\GmpBridge;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

use function gmp_strval;

#[CoversClass(GmpBridge::class)]
#[CoversMethod(GmpBridge::class, 'toGmp')]
final class ToGmpTest extends TestCase
{
    public function testConvertsBigInteger(): void
    {
        // Arrange
        $value = new BigInteger('123456789012345678901234567890');

        // Act
        $gmp = GmpBridge::toGmp($value);

        // Assert
        self::assertSame('123456789012345678901234567890', gmp_strval($gmp));
    }
}
