<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression\Comparator;

use hanneskod\yaysondb\Expression\Comparator;

/**
 * Check if supplied operand is greater than loaded operand
 */
class GreaterThan extends Comparator
{
    /**
     * Evaluate that supplied operand is greater than loaded operand
     */
    public function evaluate($operand): bool
    {
        return $operand > $this->operand;
    }
}
