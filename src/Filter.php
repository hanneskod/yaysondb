<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

/**
 * Iterator with filtered content
 */
abstract class Filter extends DocumentSet
{
    /**
     * @var \Traversable Internal iterator
     */
    private $iterator;

    /**
     * Set internal iterator
     *
     * @param  \Traversable $iterator
     * @return Filter Instance for chaining
     */
    public function setIterator(\Traversable $iterator)
    {
        $this->iterator = $iterator;
        return $this;
    }

    /**
     * Get internal iterator
     *
     * @return \Traversable
     */
    protected function getInternalIterator()
    {
        return $this->iterator;
    }
}
