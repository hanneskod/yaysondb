<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression\Counter;

use hanneskod\yaysondb\Expression\Counter;

/**
 * All contained expressions must evaluate to true
 */
class All extends Counter
{
    /**
     * Evaluate that contained expressions returns true
     */
    public function evaluate($operand): bool
    {
        foreach ($this->exprs as $expr) {
            if (!$expr->evaluate($operand)) {
                return false;
            }
        }

        return true;
    }
}
