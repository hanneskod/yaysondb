<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression;

/**
 * A comparator compares one one operand with another
 */
abstract class Comparator implements ExpressionInterface
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
