<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression\Comparator;

use hanneskod\yaysondb\Expression\Comparator;

/**
 * Check if operands equals each other
 */
class Equals extends Comparator
{
    /**
     * Evaluate that operands equals
     */
    public function evaluate($operand): bool
    {
        return $operand == $this->operand;
    }
}
