<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory\Exception;

use InvalidArgumentException;

use function sprintf;

/**
 * Thrown when a limit is larger than the maximum an operation accepts.
 */
final class LimitTooLargeException extends InvalidArgumentException implements NumberTheoryException
{
    /**
     * Creates the exception for the given limit.
     *
     * @param int $limit   The rejected limit.
     * @param int $maximum The largest limit that is accepted.
     */
    public static function exceeds(int $limit, int $maximum): self
    {
        return new self(sprintf('The limit must not be greater than %d, got %d.', $maximum, $limit));
    }
}
