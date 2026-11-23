<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Exception\UnsolvableCongruenceException;

use DomainException;
use PHPMath\NumberTheory\Exception\NumberTheoryException;
use PHPMath\NumberTheory\Exception\UnsolvableCongruenceException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(UnsolvableCongruenceException::class)]
#[CoversMethod(UnsolvableCongruenceException::class, 'inconsistent')]
final class InconsistentTest extends TestCase
{
    public function testCreatesExceptionWithMessage(): void
    {
        // Arrange

        // Act
        $exception = UnsolvableCongruenceException::inconsistent();

        // Assert
        self::assertSame('The system of congruences has no solution.', $exception->getMessage());
        self::assertInstanceOf(DomainException::class, $exception);
        self::assertInstanceOf(NumberTheoryException::class, $exception);
    }
}
