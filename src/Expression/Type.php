<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression;

/**
 * Check if $operand is of php type
 */
class Type implements ExpressionInterface
{
    /**
     * @var string Expected type descriptor
     */
    private $type;

    /**
     * Set expected type
     *
     * @param string $type Use string descriptors as returned by gettype()
     */
    public function __construct(string $type)
    {
        $this->type = $type;
    }

    /**
     * Check if $operand is of php type
     */
    public function evaluate($operand): bool
    {
        return gettype($operand) == $this->type;
    }
}
