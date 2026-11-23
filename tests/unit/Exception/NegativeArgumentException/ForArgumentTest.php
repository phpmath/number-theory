<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Exception\NegativeArgumentException;

use InvalidArgumentException;
use PHPMath\NumberTheory\Exception\NegativeArgumentException;
use PHPMath\NumberTheory\Exception\NumberTheoryException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(NegativeArgumentException::class)]
#[CoversMethod(NegativeArgumentException::class, 'forArgument')]
final class ForArgumentTest extends TestCase
{
    public function testCreatesExceptionWithMessage(): void
    {
        // Arrange

        // Act
        $exception = NegativeArgumentException::forArgument('limit', -4);

        // Assert
        self::assertSame('The argument "limit" must not be negative, got -4.', $exception->getMessage());
        self::assertInstanceOf(InvalidArgumentException::class, $exception);
        self::assertInstanceOf(NumberTheoryException::class, $exception);
    }
}
