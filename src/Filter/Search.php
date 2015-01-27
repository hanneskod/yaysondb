<?php

namespace hanneskod\yaysondb\Filter;

use hanneskod\yaysondb\Expr;

/**
 * Filter documents matching search expression
 */
class Search extends \hanneskod\yaysondb\Filter
{
    /**
     * @var Expr Search expression
     */
    private $expr;

    /**
     * Set search expression
     *
     * @param Expr $expr
     */
    public function __construct(Expr $expr)
    {
        $this->expr = $expr;
    }

    /**
     * Get iterator for documents matching search expression
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        /** @var array $doc */
        foreach ($this->getInternalIterator() as $id => $doc) {
            $doc['_id'] = $id;
            if ($this->expr->evaluate($doc)) {
                yield $id => $doc;
            }
        }
    }
}
