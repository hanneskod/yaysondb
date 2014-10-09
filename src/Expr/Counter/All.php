<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr\Counter;

/**
 * All contained expressions must evaluate to true
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class All extends \hanneskod\yaysondb\Expr\Counter
{
    /**
     * Evaluate that contained expressions returns true
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand)
    {
        foreach ($this->exprs as $expr) {
            if (!$expr->evaluate($operand)) {
                return false;
            }
        }
        return true;
    }
}
