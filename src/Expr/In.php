<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr;

/**
 * Check if $operand is included in list
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class In implements \hanneskod\yaysondb\Expr
{
    /**
     * @var array List to evaluate operands against
     */
    private $list;

    /**
     * Set the list operands are evaluated against
     *
     * @param array $list
     */
    public function __construct(array $list)
    {
        $this->list = $list;
    }

    /**
     * Check if $operand is included in list
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand)
    {
        return in_array($operand, $this->list);
    }
}
