<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr\Set;

/**
 * Expression must evaluate to true for at least one list item
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class ListAtLeastOne extends \hanneskod\yaysondb\Expr\Set
{
    /**
     * Expression must evaluate to true for at least one list item
     *
     * @param  mixed $list
     * @return bool
     */
    public function evaluate($list)
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
