<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Exception\InvalidModulusException;

use InvalidArgumentException;
use PHPMath\NumberTheory\Exception\InvalidModulusException;
use PHPMath\NumberTheory\Exception\NumberTheoryException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(InvalidModulusException::class)]
#[CoversMethod(InvalidModulusException::class, 'fromModulus')]
final class FromModulusTest extends TestCase
{
    public function testCreatesExceptionWithMessage(): void
    {
        // Arrange

        // Act
        $exception = InvalidModulusException::fromModulus('-3');

        // Assert
        self::assertSame('The modulus must be a positive integer, got -3.', $exception->getMessage());
        self::assertInstanceOf(InvalidArgumentException::class, $exception);
        self::assertInstanceOf(NumberTheoryException::class, $exception);
    }
}
