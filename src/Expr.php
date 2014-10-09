<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb;

/**
 * Document search expression
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
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
