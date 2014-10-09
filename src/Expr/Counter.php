<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr;

/**
 * A counter counts the success of contained expressions
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
abstract class Counter implements \hanneskod\yaysondb\Expr
{
    /**
     * @var hanneskod\yaysondb\Expr[] Loaded expressions
     */
    protected $exprs = [];

    /**
     * Load expressions
     *
     * @param hanneskod\yaysondb\Expr ...$exprs Any number of expressions
     */
    public function __construct(\hanneskod\yaysondb\Expr ...$exprs)
    {
        $this->exprs = $exprs;
    }
}
