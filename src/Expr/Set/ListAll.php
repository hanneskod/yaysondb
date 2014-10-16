<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr\Set;

/**
 * Expression must evaluate to true for each list item
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class ListAll extends \hanneskod\yaysondb\Expr\Set
{
    /**
     * Expression must evaluate to true for each list item
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
            if (!$this->expr->evaluate($item)) {
                return false;
            }
        }

        return true;
    }
}
