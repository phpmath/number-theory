<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Tests\Exception\NotInvertibleException;

use DomainException;
use PHPMath\NumberTheory\Exception\NotInvertibleException;
use PHPMath\NumberTheory\Exception\NumberTheoryException;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\CoversMethod;
use PHPUnit\Framework\TestCase;

#[CoversClass(NotInvertibleException::class)]
#[CoversMethod(NotInvertibleException::class, 'fromValues')]
final class FromValuesTest extends TestCase
{
    public function testCreatesExceptionWithMessage(): void
    {
        // Arrange

        // Act
        $exception = NotInvertibleException::fromValues('6', '9');

        // Assert
        self::assertSame('6 has no inverse modulo 9 because they are not coprime.', $exception->getMessage());
        self::assertInstanceOf(DomainException::class, $exception);
        self::assertInstanceOf(NumberTheoryException::class, $exception);
    }
}
