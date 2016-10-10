<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression\Set;

use hanneskod\yaysondb\Expression\Set;

/**
 * Expression must evaluate to true for at least one list item
 */
class ListAtLeastOne extends Set
{
    /**
     * Expression must evaluate to true for at least one list item
     */
    public function evaluate($list): bool
    {
        if (!is_array($list)) {
            return false;
        }

        foreach ($list as $item) {
            if ($this->expr->evaluate($item)) {
                return true;
            }
        }

        return false;
    }
}
