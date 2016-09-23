<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expr\Comparator;

/**
 * Check if operands are the same
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
