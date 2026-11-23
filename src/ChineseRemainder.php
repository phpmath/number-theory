<?php

/**
 * phpmath / number-theory (https://github.com/phpmath/number-theory)
 *
 * @link https://github.com/phpmath/number-theory for the canonical source repository
 */

declare(strict_types=1);

namespace PHPMath\NumberTheory;

use PHPMath\NumberTheory\Exception\EmptyCongruenceSystemException;
use PHPMath\NumberTheory\Exception\UnsolvableCongruenceException;

/**
 * Solves systems of simultaneous congruences (Chinese remainder theorem).
 *
 * The moduli do not have to be pairwise coprime, the system is solved as long as it is consistent.
 */
final class ChineseRemainder
{
    /** @codeCoverageIgnore The constructor only prevents instantiation. */
    private function __construct()
    {
    }

    /**
     * Solves a system of congruences.
     *
     * @param Congruence ...$congruences The congruences to satisfy simultaneously.
     *
     * @return Congruence The solution: x is congruent to remainder modulo the lcm of all moduli.
     *
     * @throws EmptyCongruenceSystemException Thrown if no congruence is given.
     * @throws UnsolvableCongruenceException Thrown if the system is inconsistent.
     */
    public static function solve(Congruence ...$congruences): Congruence
    {
        if ($congruences === []) {
            throw EmptyCongruenceSystemException::create();
        }

        $solution = null;

        foreach ($congruences as $congruence) {
            $solution = $solution === null ? $congruence : self::combine($solution, $congruence);
        }

        return $solution;
    }

    /**
     * Merges two congruences into one.
     *
     * @param Congruence $first  The first congruence.
     * @param Congruence $second The second congruence.
     *
     * @throws UnsolvableCongruenceException Thrown if the congruences contradict each other.
     */
    private static function combine(Congruence $first, Congruence $second): Congruence
    {
        $bezout = Divisibility::extendedGcd($first->modulus, $second->modulus);
        $difference = $second->remainder->subtract($first->remainder);

        if (!Divisibility::divides($bezout->gcd, $difference)) {
            throw UnsolvableCongruenceException::inconsistent();
        }

        $reducedModulus = $second->modulus->divide($bezout->gcd);
        $step = $difference->divide($bezout->gcd)->multiply($bezout->x)->mod($reducedModulus);

        return new Congruence(
            $first->remainder->add($first->modulus->multiply($step)),
            $first->modulus->multiply($reducedModulus),
        );
    }
}
