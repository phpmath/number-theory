<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Exception\LimitTooLargeException;

use InvalidArgumentException;
use PHPMath\NumberTheory\Exception\LimitTooLargeException;
use PHPMath\NumberTheory\Exception\NumberTheoryException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(LimitTooLargeException::class)]
#[CoversMethod(LimitTooLargeException::class, 'exceeds')]
final class ExceedsTest extends TestCase
{
    public function testCreatesExceptionWithMessage(): void
    {
        // Arrange

        // Act
        $exception = LimitTooLargeException::exceeds(20, 10);

        // Assert
        self::assertSame('The limit must not be greater than 10, got 20.', $exception->getMessage());
        self::assertInstanceOf(InvalidArgumentException::class, $exception);
        self::assertInstanceOf(NumberTheoryException::class, $exception);
    }
}
