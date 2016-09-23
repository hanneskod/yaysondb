<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expr;

/**
 * Evaluate expression for each item in list
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
