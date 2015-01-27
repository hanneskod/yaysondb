<?php

namespace hanneskod\yaysondb\Filter;

/**
 * Search limit filter
 */
class Limit extends \hanneskod\yaysondb\Filter
{
    /**
     * @var int The number of documents to return
     */
    private $count;

    /**
     * @var int The offset of the first document to return
     */
    private $offset;

    /**
     * Set limit clause
     *
     * @param int $count  The number of documents to return
     * @param int $offset The offset of the first document to return
     */
    public function __construct($count, $offset = 0)
    {
        $this->count = $count;
        $this->offset = $offset;
    }

    /**
     * Get iterator with filtered content
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        $count = 0;
        foreach ($this->getInternalIterator() as $id => $doc) {
            $count++;
            if ($count <= $this->offset) {
                continue;
            }
            if ($count > $this->count + $this->offset) {
                break;
            }
            yield $id => $doc;
        }
    }
}
