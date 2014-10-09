<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb;

/**
 * Collection handler
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Yaysondb
{
    /**
     * @var Adapter IO adapter
     */
    private $adapter;

    /**
     * @var Collection[] List of loaded collections
     */
    private $collections = [];

    /**
     * Register IO adapter
     *
     * @param Adapter $adapter
     */
    public function __construct(Adapter $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * Get collection
     *
     * @param  string $id
     * @return Collection
     */
    public function collection($id)
    {
        if (!isset($this->collections[$id])) {
            $this->collections[$id] = new Collection(
                $this->adapter->read($id)
            );
        }
        return $this->collections[$id];
    }

    /**
     * Magic method to allow collection access through property name
     *
     * @param  string $id
     * @return Collection
     */
    public function __get($id)
    {
        return $this->collection($id);
    }

    /**
     * Write collection to persistent storage
     *
     * @param  string $id
     */
    public function persist($id)
    {
        $this->adapter->write(
            $id,
            json_encode($this->collection($id), JSON_PRETTY_PRINT)
        );
    }
}