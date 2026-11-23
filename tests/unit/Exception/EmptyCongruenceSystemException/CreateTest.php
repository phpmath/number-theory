<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Exception\EmptyCongruenceSystemException;

use InvalidArgumentException;
use PHPMath\NumberTheory\Exception\EmptyCongruenceSystemException;
use PHPMath\NumberTheory\Exception\NumberTheoryException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(EmptyCongruenceSystemException::class)]
#[CoversMethod(EmptyCongruenceSystemException::class, 'create')]
final class CreateTest extends TestCase
{
    public function testCreatesExceptionWithMessage(): void
    {
        // Arrange

        // Act
        $exception = EmptyCongruenceSystemException::create();

        // Assert
        self::assertSame('At least one congruence is required.', $exception->getMessage());
        self::assertInstanceOf(InvalidArgumentException::class, $exception);
        self::assertInstanceOf(NumberTheoryException::class, $exception);
    }
}
