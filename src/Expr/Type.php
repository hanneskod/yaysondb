<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expr;

/**
 * Check if $operand is of php type
 */
class Type implements \hanneskod\yaysondb\Expr
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
    public function __construct($type)
    {
        $this->type = $type;
    }

    /**
     * Check if $operand is of php type
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand)
    {
        return gettype($operand) == $this->type;
    }
}
