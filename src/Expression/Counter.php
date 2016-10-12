<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression;

/**
 * A counter counts the success of contained expressions
 */
abstract class Counter implements ExpressionInterface
{
    /**
     * @var ExpressionInterface[] Loaded expressions
     */
    protected $exprs = [];

    /**
     * Load expressions
     *
     * @param ExpressionInterface ...$exprs Any number of expressions
     */
    public function __construct(ExpressionInterface ...$exprs)
    {
        $this->exprs = $exprs;
    }
}
