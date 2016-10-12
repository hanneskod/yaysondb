<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression;

use hanneskod\yaysondb\Exception\RuntimeException;

/**
 * Evaluate documents and nested subdocuments
 */
class Doc implements ExpressionInterface
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
        /** @var ExpressionInterface $expr */
        foreach ($query as $key => $expr) {
            if (!$expr instanceof ExpressionInterface) {
                throw new RuntimeException(
                    "Query operator must implement ExpressionInterface, found: ".gettype($expr)
                );
            }

            $this->exprs[] = function (array $doc) use ($key, $expr) {
                return isset($doc[$key]) && $expr->evaluate($doc[$key]);
            };
        }
    }

    public function evaluate($doc): bool
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
