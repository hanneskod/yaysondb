<?php

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Expression\ExpressionInterface;
use hanneskod\yaysondb\Filter\FilterInterface;

/**
 * Defines a filterable set of documents
 */
interface FilterableInterface extends \Countable, \IteratorAggregate
{
    /**
     * Call callable once for each contained document
     */
    public function each(callable $callable);

    /**
     * Create a new filterable with filtered content
     */
    public function filter(FilterInterface $filter): FilterableInterface;

    /**
     * Create a new filterable with documents matching expression
     */
    public function find(ExpressionInterface $expression): FilterableInterface;

    /**
     * Get first document matching expression
     */
    public function findOne(ExpressionInterface $expression): array;

    /**
     * Get the first document in set
     */
    public function first(): array;

    /**
     * Check if there are any documents
     */
    public function isEmpty(): bool;

    /**
     * Limit the number of returned documents
     *
     * @param int $count  The number of documents to return
     * @param int $offset The offset of the first document to return
     */
    public function limit(int $count, int $offset = 0): FilterableInterface;

    /**
     * Sort result set
     *
     * @param string ...$keys Any number of document keys
     */
    public function orderBy(string ...$keys): FilterableInterface;

    /**
     * Filter documents using a custom filter
     *
     * @param callable $callable Filter that takes an array document as argument
     *     and returns true if it should be keept, false it not
     */
    public function where(callable $callable): FilterableInterface;
}
