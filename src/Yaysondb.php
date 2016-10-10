<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

/**
 * Handle to a defined set of collections
 */
class Yaysondb implements TransactableInterface
{
    /**
     * @var Collection[] Loaded collections
     */
    private $collections;

    /**
     * Load collections
     *
     * @param CollectionInterface[] $collections Map of identifiers to collections
     */
    public function __construct(array $collections)
    {
        $this->collections = $collections;
    }

    /**
     * Get collection
     *
     * @throws Exception\LogicException If id is not defined
     */
    public function collection(string $id): CollectionInterface
    {
        if (!isset($this->collections[$id])) {
            throw new Exception\LogicException("Trying to access undefined collection $id");
        }

        return $this->collections[$id];
    }

    /**
     * Magic method to allow collection access through property name
     */
    public function __get(string $id): CollectionInterface
    {
        return $this->collection($id);
    }

    public function commit()
    {
        foreach ($this->collections as $collection) {
            if ($collection->inTransaction()) {
                $collection->commit();
            }
        }
    }

    public function inTransaction(): bool
    {
        foreach ($this->collections as $collection) {
            if ($collection->inTransaction()) {
                return true;
            }
        }

        return false;
    }

    public function reset()
    {
        foreach ($this->collections as $collection) {
            if ($collection->inTransaction()) {
                $collection->reset();
            }
        }
    }
}
