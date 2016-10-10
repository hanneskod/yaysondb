<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression;

/**
 * Empty expression
 *
 * Use to assert that a document key exists
 */
class Exists implements ExpressionInterface
{
    /**
     * Evaluates to true
     */
    public function evaluate($operand): bool
    {
        return true;
    }
}
