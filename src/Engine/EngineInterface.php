<?php

namespace hanneskod\yaysondb\Engine;

use hanneskod\yaysondb\TransactableInterface;

/**
 * Defines engines responsible for managing the content source
 */
interface EngineInterface extends TransactableInterface, \IteratorAggregate
{
    /**
     * Remove all documents from source
     */
    public function clear();

    /**
     * Delete document
     *
     * @param  string $id Id of document to delete
     * @return bool   True if delete was successful, false if not
     */
    public function delete(string $id): bool;

    /**
     * Check if document id exists
     */
    public function has(string $id): bool;

    /**
     * Read document
     *
     * @param  string $id Id of document to read
     * @return array  The document
     */
    public function read(string $id): array;

    /**
     * Write document
     *
     * @param  string $id  Id of document to write (empty to generate id)
     * @param  array  $doc The new document
     * @return string Id of written document
     */
    public function write(string $id, array $doc): string;
}
