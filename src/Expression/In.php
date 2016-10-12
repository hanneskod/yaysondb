<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression;

/**
 * Check if $operand is included in list
 */
class In implements ExpressionInterface
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
     */
    public function evaluate($operand): bool
    {
        return in_array($operand, $this->list);
    }
}
