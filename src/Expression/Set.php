<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression;

/**
 * Evaluate expression for each item in list
 */
abstract class Set implements ExpressionInterface
{
    /**
     * @var ExpressionInterface Loaded expression
     */
    protected $expr;

    /**
     * Set expression to validate all list items against
     *
     * @param ExpressionInterface $expr
     */
    public function __construct(ExpressionInterface $expr)
    {
        $this->expr = $expr;
    }
}
