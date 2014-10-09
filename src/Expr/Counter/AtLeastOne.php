<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr\Counter;

/**
 * At least one contained expressions must evaluate to true
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class AtLeastOne extends \hanneskod\yaysondb\Expr\Counter
{
    /**
     * Evaluate that at least one contained expressions returns true
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand)
    {
        foreach ($this->exprs as $expr) {
            if ($expr->evaluate($operand)) {
                return true;
            }
        }
        return false;
    }
}
