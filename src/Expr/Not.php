<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expr;

/**
 * Negate expression
 */
class Not implements \hanneskod\yaysondb\Expr
{
    /**
     * @var \hanneskod\yaysondb\Expr Expression to negate
     */
    private $expr;

    /**
     * Load expression
     *
     * @param \hanneskod\yaysondb\Expr $expr
     */
    public function __construct(\hanneskod\yaysondb\Expr $expr)
    {
        $this->expr = $expr;
    }

    /**
     * Negate contained expression
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand)
    {
        return !$this->expr->evaluate($operand);
    }
}
