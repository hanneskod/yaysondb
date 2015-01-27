<?php

namespace hanneskod\yaysondb\Expr\Comparator;

/**
 * Check if operands equals each other
 */
class Equals extends \hanneskod\yaysondb\Expr\Comparator
{
    /**
     * Evaluate that operands equals
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand)
    {
        return $operand == $this->operand;
    }
}
