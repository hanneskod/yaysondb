<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr\Comparator;

/**
 * Check if operands are the same
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Same extends \hanneskod\yaysondb\Expr\Comparator
{
    /**
     * Evaluate that operands are the same
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand)
    {
        return $operand === $this->operand;
    }
}
