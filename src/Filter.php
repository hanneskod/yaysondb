<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb;

/**
 * Iterator with filtered content
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
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
