<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Exception\InvalidNumberException;

use InvalidArgumentException;
use PHPMath\NumberTheory\Exception\InvalidNumberException;
use PHPMath\NumberTheory\Exception\NumberTheoryException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(InvalidNumberException::class)]
#[CoversMethod(InvalidNumberException::class, 'expected')]
final class ExpectedTest extends TestCase
{
    public function testCreatesExceptionWithMessage(): void
    {
        // Arrange

        // Act
        $exception = InvalidNumberException::expected('a prime number', '15');

        // Assert
        self::assertSame('Expected a prime number, got 15.', $exception->getMessage());
        self::assertInstanceOf(InvalidArgumentException::class, $exception);
        self::assertInstanceOf(NumberTheoryException::class, $exception);
    }
}
