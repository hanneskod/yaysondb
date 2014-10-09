<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr;

/**
 * A comparator compares one one operand with another
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
abstract class Comparator implements \hanneskod\yaysondb\Expr
{
    /**
     * @var mixed Operand to compare
     */
    protected $operand;

    /**
     * Specify operand to compare
     *
     * @param mixed $operand
     */
    public function __construct($operand)
    {
        $this->operand = $operand;
    }
}
