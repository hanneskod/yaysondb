<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression\Set;

use hanneskod\yaysondb\Expression\ExpressionInterface;
use hanneskod\yaysondb\Expression\Set;

/**
 * Expression must evaluate to true for exact numer of items in list
 */
class ListExactly extends Set
{
    /**
     * @var int Target count
     */
    private $count;

    /**
     * Set target count
     *
     * @param int $count
     * @param ExpressionInterface $expr
     */
    public function __construct(int $count, ExpressionInterface $expr)
    {
        $this->count = $count;
        parent::__construct($expr);
    }

    /**
     * Expression must evaluate to true for exact numer of items in list
     */
    public function evaluate($list): bool
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
