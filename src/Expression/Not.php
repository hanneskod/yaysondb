<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression;

/**
 * Negate expression
 */
class Not implements ExpressionInterface
{
    /**
     * @var ExpressionInterface Expression to negate
     */
    private $expr;

    /**
     * Load expression
     *
     * @param ExpressionInterface $expr
     */
    public function __construct(ExpressionInterface $expr)
    {
        $this->expr = $expr;
    }

    /**
     * Negate contained expression
     */
    public function evaluate($operand): bool
    {
        return !$this->expr->evaluate($operand);
    }
}
