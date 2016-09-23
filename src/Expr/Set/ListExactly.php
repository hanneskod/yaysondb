<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expr\Set;

/**
 * Expression must evaluate to true for exact numer of items in list
 */
class ListExactly extends \hanneskod\yaysondb\Expr\Set
{
    /**
     * @var int Target count
     */
    private $count;

    /**
     * Set target count
     *
     * @param int $count
     * @param \hanneskod\yaysondb\Expr $expr
     */
    public function __construct($count, \hanneskod\yaysondb\Expr $expr)
    {
        $this->count = $count;
        parent::__construct($expr);
    }

    /**
     * Expression must evaluate to true for exact numer of items in list
     *
     * @param  mixed $list
     * @return bool
     */
    public function evaluate($list)
    {
        if (!is_array($list)) {
            return false;
        }

        $count = 0;

        foreach ($list as $item) {
            if ($this->expr->evaluate($item)) {
                $count++;
            }
        }

        return $count == $this->count;
    }
}
