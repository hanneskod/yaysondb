<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression\Counter;

use hanneskod\yaysondb\Expression\Counter;

/**
 * At least one contained expressions must evaluate to true
 */
class AtLeastOne extends Counter
{
    /**
     * Evaluate that at least one contained expressions returns true
     */
    public function evaluate($operand): bool
    {
        foreach ($this->exprs as $expr) {
            if ($expr->evaluate($operand)) {
                return true;
            }
        }

        return false;
    }
}
