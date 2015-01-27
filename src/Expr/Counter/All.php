<?php

namespace hanneskod\yaysondb\Expr\Counter;

/**
 * All contained expressions must evaluate to true
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
