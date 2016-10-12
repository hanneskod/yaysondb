<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Engine\EngineInterface;

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
     * Optionally load collection engines
     *
     * @param EngineInterface[] $engines Maps identifiers to engines
     */
    public function __construct(array $engines = [])
    {
        foreach ($engines as $engineId => $engine) {
            $this->load(
                $engine,
                is_string($engineId) ? $engineId : ''
            );
        }
    }

    /**
     * Load collection engine
     */
    public function load(EngineInterface $engine, string $engineId = ''): self
    {
        $this->collections[$engineId ?: $engine->getId()] = new Collection($engine);
        return $this;
    }

    /**
     * Check if handle contains collection with id
     */
    public function hasCollection(string $id): bool
    {
        return isset($this->collections[$id]);
    }

    /**
     * Magic method to allow collection exploration through property names
     */
    public function __isset(string $id): bool
    {
        return $this->hasCollection($id);
    }

    /**
     * Get collection
     *
     * @throws Exception\LogicException If id is not defined
     */
    public function collection(string $id): CollectionInterface
    {
        if (!$this->hasCollection($id)) {
            throw new Exception\LogicException("Trying to access undefined collection $id");
        }

        return $this->collections[$id];
    }

    /**
     * Magic method to allow collection access through property names
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
