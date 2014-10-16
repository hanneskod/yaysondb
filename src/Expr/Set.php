<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr;

/**
 * Evaluate expression for each item in list
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
abstract class Set implements \hanneskod\yaysondb\Expr
{
    /**
     * @var \hanneskod\yaysondb\Expr Loaded expression
     */
    protected $expr;

    /**
     * Set expression to validate all list items against
     *
     * @param \hanneskod\yaysondb\Expr $expr
     */
    public function __construct(\hanneskod\yaysondb\Expr $expr)
    {
        $this->expr = $expr;
    }
}
