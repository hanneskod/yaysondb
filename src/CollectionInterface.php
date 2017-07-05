<?php

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Expression\ExpressionInterface;

/**
 * Defines an editable collection of documents
 */
interface CollectionInterface extends FilterableInterface, TransactableInterface
{
    /**
     * Delete all documents matching expression
     *
     * @return int The number of deleted documents
     */
    public function delete(ExpressionInterface $expression): int;

    /**
     * Check if document id exists in collection
     */
    public function has(string $id): bool;

    /**
     * Insert document into collection
     *
     * @param  array  $document Document to insert
     * @param  string $id       Optional document id
     * @return string Id of inserted document
     */
    public function insert(array $document, string $id = ''): string;

    /**
     * Get document from id
     */
    public function read(string $id): array;

    /**
     * Update all documents matching expression
     *
     * @return int The number of updated documents
     */
    public function update(ExpressionInterface $expression, array $newDocument): int;
}
