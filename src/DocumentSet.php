<?php

namespace hanneskod\yaysondb;

/**
 * Filterable set of documents
 */
abstract class DocumentSet implements \IteratorAggregate
{
    /**
     * Get a new document set containing documents matching expression
     *
     * @param  Expr $expr Search expression
     * @return Filter\Search
     */
    public function find(Expr $expr)
    {
        return (new Filter\Search($expr))->setIterator($this);
    }

    /**
     * Get a new document set with limited content
     *
     * @param  int $count  The number of documents returned
     * @param  int $offset The offset of the first document to retirn
     * @return Filter\Limit
     */
    public function limit($count, $offset = 0)
    {
        return (new Filter\Limit($count, $offset))->setIterator($this);
    }

    /**
     * Get a new document set with ordered content
     *
     * @param string ...$keys Any number of document keys
     * @return Filter\OrderBy
     */
    public function orderBy(...$keys)
    {
        return (new Filter\OrderBy(...$keys))->setIterator($this);
    }
}
