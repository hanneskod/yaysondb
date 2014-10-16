<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Filter;

/**
 * Order by filter
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class OrderBy extends \hanneskod\yaysondb\Filter
{
    /**
     * @var array List of keys to use while ordering
     */
    private $keys;

    /**
     * Set keys used while ordering
     *
     * @param string ...$keys Any number of document keys
     */
    public function __construct(...$keys)
    {
        $this->keys = $keys;
    }

    /**
     * Get iterator with ordered content
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        $docs = iterator_to_array($this->getInternalIterator());
        uasort($docs, [$this, 'compare']);
        foreach ($docs as $id => $doc) {
            yield $id => $doc;
        }
    }

    /**
     * Compare items
     *
     * @param  mixed $itemA
     * @param  mixed $itemB
     * @return int
     */
    public function compare($itemA, $itemB)
    {
        return strcasecmp(
            $this->buildSearchKey($itemA),
            $this->buildSearchKey($itemB)
        );
    }

    /**
     * Build a search key from item
     *
     * @param  mixed $item
     * @return string
     */
    private function buildSearchKey($item)
    {
        $item = (array)$item;
        $searchKey = '';
        foreach ($this->keys as $key) {
            if (isset($item[$key])) {
                $searchKey .= $item[$key];
            }
        }
        return $searchKey;
    }
}
