<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Expression\ExpressionInterface;
use hanneskod\yaysondb\Filter\CallableFilter;
use hanneskod\yaysondb\Filter\ExpressionFilter;
use hanneskod\yaysondb\Filter\FilterInterface;
use hanneskod\yaysondb\Filter\LimitFilter;
use hanneskod\yaysondb\Filter\OrderByFilter;

/**
 * Basic implementation of FilterableInterface
 */
class Filterable implements FilterableInterface
{
    /**
     * @var \Traversable Contained set of documents
     */
    private $docs;

    public function __construct(\Traversable $docs)
    {
        $this->docs = $docs;
    }

    public function count(): int
    {
        $count = 0;

        foreach ($this->getIterator() as $doc) {
            $count ++;
        }

        return $count;
    }

    public function each(callable $callable)
    {
        foreach ($this as $doc) {
            $callable($doc);
        }
    }

    public function filter(FilterInterface $filter): FilterableInterface
    {
        return new Filterable($filter->filter($this));
    }

    public function find(ExpressionInterface $expression): FilterableInterface
    {
        return $this->filter(new ExpressionFilter($expression));
    }

    public function findOne(ExpressionInterface $expression): array
    {
        return $this->find($expression)->first();
    }

    public function first(): array
    {
        foreach ($this as $doc) {
            return (array)$doc;
        }

        return [];
    }

    public function getIterator(): \Generator
    {
        foreach ($this->docs as $doc) {
            yield $doc;
        }
    }

    public function isEmpty(): bool
    {
        foreach ($this as $doc) {
            return false;
        }

        return true;
    }

    public function limit(int $count, int $offset = 0): FilterableInterface
    {
        return $this->filter(new LimitFilter($count, $offset));
    }

    public function orderBy(string ...$keys): FilterableInterface
    {
        return $this->filter(new OrderByFilter(...$keys));
    }

    public function where(callable $callable): FilterableInterface
    {
        return $this->filter(new CallableFilter($callable));
    }
}
