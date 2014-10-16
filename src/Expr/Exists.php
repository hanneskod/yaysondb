<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr;

/**
 * Empty expression
 *
 * Use to assert that a document key exists
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
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
