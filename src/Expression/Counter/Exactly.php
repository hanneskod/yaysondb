<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression\Counter;

use hanneskod\yaysondb\Expression\Counter;
use hanneskod\yaysondb\Expression\ExpressionInterface;

/**
 * Match exact number of contained expressions evaluating to true
 */
class Exactly extends Counter
{
    /**
     * @var int Target count
     */
    private $count;

    /**
     * Load expressions
     *
     * @param int $count
     * @param ExpressionInterface ...$exprs Any number of expressions
     */
    public function __construct(int $count, ExpressionInterface ...$exprs)
    {
        $this->count = $count;
        parent::__construct(...$exprs);
    }

    /**
     * Evaluate that the exact number of contained expressions returns true
     */
    public function evaluate($operand): bool
    {
        $count = 0;

        foreach ($this->exprs as $expr) {
            if ($expr->evaluate($operand)) {
                $count++;
            }
        }

        return $count == $this->count;
    }
}
