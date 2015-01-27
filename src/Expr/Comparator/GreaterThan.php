<?php

namespace hanneskod\yaysondb\Expr\Comparator;

/**
 * Check if supplied operand is greater than loaded operand
 */
class GreaterThan extends \hanneskod\yaysondb\Expr\Comparator
{
    /**
     * Evaluate that supplied operand is greater than loaded operand
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand)
    {
        return $operand > $this->operand;
    }
}
