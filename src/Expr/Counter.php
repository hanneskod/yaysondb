<?php

namespace hanneskod\yaysondb\Expr;

/**
 * A counter counts the success of contained expressions
 */
abstract class Counter implements \hanneskod\yaysondb\Expr
{
    /**
     * @var \hanneskod\yaysondb\Expr[] Loaded expressions
     */
    protected $exprs = [];

    /**
     * Load expressions
     *
     * @param \hanneskod\yaysondb\Expr ...$exprs Any number of expressions
     */
    public function __construct(\hanneskod\yaysondb\Expr ...$exprs)
    {
        $this->exprs = $exprs;
    }
}
