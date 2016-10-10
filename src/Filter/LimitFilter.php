<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Filter;

/**
 * Limit the number of returned documents
 */
class LimitFilter implements FilterInterface
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
    public function __construct(int $count, int $offset = 0)
    {
        $this->count = $count;
        $this->offset = $offset;
    }

    public function filter(\Traversable $documents): \Generator
    {
        $count = 0;

        foreach ($documents as $id => $doc) {
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
