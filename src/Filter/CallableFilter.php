<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Filter;

use hanneskod\yaysondb\Expression\ExpressionInterface;

/**
 * Filter documents matching a custom callable
 */
class CallableFilter implements FilterInterface
{
    /**
     * @var callable Custom filter
     */
    private $callable;

    /**
     * Set custom filter
     *
     * @param callable $callable Should take on argument and return a boolean
     */
    public function __construct(callable $callable)
    {
        $this->callable = $callable;
    }

    public function filter(\Traversable $documents): \Generator
    {
        foreach ($documents as $id => $doc) {
            if (($this->callable)($doc)) {
                yield $id => $doc;
            }
        }
    }
}
