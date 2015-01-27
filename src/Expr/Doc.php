<?php

namespace hanneskod\yaysondb\Expr;

/**
 * Evaluate documents and nested subdocuments
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
        /** @var \hanneskod\yaysondb\Expr $expr */
        foreach ($query as $key => $expr) {
            if (!$expr instanceof \hanneskod\yaysondb\Expr) {
                throw new \hanneskod\yaysondb\Exception\InvalidArgumentException(
                    "Query operator must implement the Operator interface, found: ".gettype($expr)
                );
            }
            $this->exprs[] = function (array $doc) use ($key, $expr) {
                return isset($doc[$key]) && $expr->evaluate($doc[$key]);
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
