<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expr;

/**
 * Empty expression
 *
 * Use to assert that a document key exists
 */
class Exists implements \hanneskod\yaysondb\Expr
{
    /**
     * Evaluates to true
     *
     * @param  mixed $operand
     * @return true
     */
    public function evaluate($operand)
    {
        return true;
    }
}
