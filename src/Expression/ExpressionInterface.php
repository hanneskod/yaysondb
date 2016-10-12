<?php

namespace hanneskod\yaysondb\Expression;

/**
 * Defines a document search expression
 */
interface ExpressionInterface
{
    /**
     * Evaluate this operator expression
     */
    public function evaluate($operand): bool;
}
