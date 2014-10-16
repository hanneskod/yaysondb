<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr\Counter;

/**
 * Match exact number of contained expressions evaluating to true
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Exactly extends \hanneskod\yaysondb\Expr\Counter
{
    /**
     * @var int Target count
     */
    private $count;

    /**
     * Load expressions
     *
     * @param int $count
     * @param \hanneskod\yaysondb\Expr ...$exprs Any number of expressions
     */
    public function __construct($count, \hanneskod\yaysondb\Expr ...$exprs)
    {
        $this->count = $count;
        parent::__construct(...$exprs);
    }

    /**
     * Evaluate that the exact number of contained expressions returns true
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand)
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
