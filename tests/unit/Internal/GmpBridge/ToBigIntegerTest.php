<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Internal\GmpBridge;

use PHPMath\NumberTheory\Internal\GmpBridge;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

use function gmp_init;

#[CoversClass(GmpBridge::class)]
#[CoversMethod(GmpBridge::class, 'toBigInteger')]
final class ToBigIntegerTest extends TestCase
{
    public function testConvertsGmp(): void
    {
        // Arrange
        $gmp = gmp_init('-123456789012345678901234567890');

        // Act
        $value = GmpBridge::toBigInteger($gmp);

        // Assert
        self::assertSame('-123456789012345678901234567890', $value->value());
    }
}
