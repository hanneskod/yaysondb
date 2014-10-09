<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr\Comparator;

/**
 * Check if operands equals each other
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
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
