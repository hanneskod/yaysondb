<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr;

/**
 * Evaluate documents and nested subdocuments
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Doc implements \hanneskod\yaysondb\Expr
{
    /**
     * @var \Closure[] List of expressions
     */
    private $exprs = [];

    /**
     * Create from query document
     *
     * @param array $query
     */
    public function __construct(array $query)
    {
        /** @var Operator $op */
        foreach ($query as $key => $op) {
            if (!$op instanceof \hanneskod\yaysondb\Expr) {
                throw new \hanneskod\yaysondb\Exception\InvalidArgumentException(
                    "Query operator must implement the Operator interface, found: ".gettype($op)
                );
            }
            $this->exprs[] = function (array $doc) use ($key, $op) {
                return isset($doc[$key]) && $op->evaluate($doc[$key]);
            };
        }
    }

    /**
     * Evaluate document
     *
     * @param  mixed $doc
     * @return bool
     */
    public function evaluate($doc)
    {
        if (!is_array($doc)) {
            return false;
        }

        /** @var \Closure $exp */
        foreach ($this->exprs as $exp) {
            if (!$exp($doc)) {
                return false;
            }
        }
        return true;
    }
}
