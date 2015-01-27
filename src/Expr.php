<?php

namespace hanneskod\yaysondb;

/**
 * Document search expression
 */
interface Expr
{
    /**
     * Evaluate this operator expression
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand);
}
