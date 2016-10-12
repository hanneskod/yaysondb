<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Filter;

/**
 * Sort result set
 */
class OrderByFilter implements FilterInterface
{
    /**
     * @var array List of keys to use while ordering
     */
    private $keys;

    /**
     * Set keys used while sorting
     *
     * @param string ...$keys Any number of document keys
     */
    public function __construct(string ...$keys)
    {
        $this->keys = $keys;
    }

    public function filter(\Traversable $documents): \Generator
    {
        $docs = iterator_to_array($documents);

        $makeCmpStr = function (array $item) {
            return array_reduce($this->keys, function ($carry, $key) use ($item) {
                return $carry .= $item[$key] ?? '';
            });
        };

        uasort($docs, function ($left, $right) use ($makeCmpStr) {
            return strcasecmp($makeCmpStr((array)$left), $makeCmpStr((array)$right));
        });

        foreach ($docs as $id => $doc) {
            yield $id => $doc;
        }
    }
}
