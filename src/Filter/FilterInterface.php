<?php

namespace hanneskod\yaysondb\Filter;

/**
 * Defines a document filter
 */
interface FilterInterface
{
    /**
     * Create a new generator with filtered content
     */
    public function filter(\Traversable $documents): \Generator;
}
