<?php

namespace hanneskod\yaysondb;

/**
 * Yayson database engine
 */
class Collection extends DocumentSet implements \Countable, \JsonSerializable
{
    /**
     * @var array Internal document store
     */
    private $collection;

    /**
     * Load db from json string
     *
     * @param  string $json
     * @throws Exception\InvalidCollectionException If $json is not valid
     */
    public function __construct($json = '[]')
    {
        $this->collection = json_decode($json, true);
        if (!is_array($this->collection)) {
            throw new Exception\InvalidCollectionException("Invalid json collection");
        }
    }

    /**
     * Check if document with _id exists in collection
     *
     * @param  scalar $id
     * @return bool
     */
    public function containsDocument($id)
    {
        return isset($this->collection[$id]);
    }

    /**
     * Get document with _id
     *
     * @param  scalar $id
     * @return array
     * @throws Exception\InvalidDocumentException If $id does not exist
     */
    public function getDocument($id)
    {
        if (!$this->containsDocument($id)) {
            throw new Exception\InvalidDocumentException(
                "Document with id <$id> does not exist"
            );
        }
        return array_merge(
            $this->collection[$id],
            ['_id' => $id]
        );
    }

    /**
     * Get first document matching expression
     *
     * @param  Expr  $expr Search expression
     * @return array
     */
    public function findOne(Expr $expr)
    {
        foreach ($this->find($expr) as $doc) {
            return $doc;
        }
        return [];
    }

    /**
     * Insert document
     *
     * @param  array  $doc
     * @return string Id of inserted document
     * @throws Exception\DocumentDuplicationException If _id exist in collection
     */
    public function insert(array $doc)
    {
        $id = isset($doc['_id'])
            ? $this->validateId($doc['_id'])
            : $this->generateId();

        if ($this->containsDocument($id)) {
            throw new Exception\DocumentDuplicationException(
                "Unable to insert <$id>, document already exists"
            );
        }

        unset($doc['_id']);
        $this->collection[$id] = $doc;
        return $id;
    }

    /**
     * Update all documents matching expression
     *
     * @param  Expr  $expr Search expression
     * @param  array $doc
     * @return int   The number of updated documents
     */
    public function update(Expr $expr, array $doc)
    {
        $count = 0;
        foreach ($this->find($expr) as $oldId => $oldDoc) {
            $doc = array_replace_recursive($oldDoc, $doc);
            $id = $this->validateId($doc['_id']);
            if ($oldId != $id) {
                if ($this->containsDocument($id)) {
                    throw new Exception\DocumentDuplicationException(
                        "Unable to update id to <$id>, document already exists"
                    );
                }
                unset($this->collection[$oldId]);
            }
            unset($doc['_id']);
            $this->collection[$id] = $doc;
            $count++;
        }
        return $count;
    }

    /**
     * Delete all documents matching expression
     *
     * @param  Expr  $expr Search expression
     * @return int   The number of deleted documents
     */
    public function delete(Expr $expr)
    {
        $count = 0;
        foreach ($this->find($expr) as $id => $doc) {
            unset($this->collection[$id]);
            $count++;
        }
        return $count;
    }

    /**
     * Get iterator for the complete collection
     *
     * @return \Traversable
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->collection);
    }

    /**
     * Get collection count
     *
     * @return int
     */
    public function count()
    {
        return count($this->collection);
    }

    /**
     * Specify data which should be serialized to JSON
     *
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->collection;
    }

    /**
     * Generate a unique id
     *
     * @return string
     */
    private function generateId()
    {
        $id = time() . rand(1000, 9999);
        return $this->containsDocument($id) ? $this->generateId() : $id;
    }

    /**
     * Validate document id
     *
     * @param  string $id
     * @return string The validated id
     * @throws Exception\InvalidDocumentException If document id is not valid
     */
    private function validateId($id)
    {
        if (!is_scalar($id)) {
            throw new Exception\InvalidDocumentException(
                "Document _id must be scalar, found: ".gettype($id)
            );
        }
        if (empty($id)) {
            throw new Exception\InvalidDocumentException(
                "Document _id can not be empty"
            );
        }
        return $id;
    }
}
