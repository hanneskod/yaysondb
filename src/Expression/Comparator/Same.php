<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression\Comparator;

use hanneskod\yaysondb\Expression\Comparator;

/**
 * Check if operands are the same
 */
class Same extends Comparator
{
    /**
     * Evaluate that operands are the same
     */
    public function evaluate($operand): bool
    {
        return $operand === $this->operand;
    }
}
