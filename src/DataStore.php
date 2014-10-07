<?php

namespace hanneskod\jsondb;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface DataStore
{
    /**
     * Get all records matching conditions
     *
     * @param  array  $conditions
     * @return \Generator
     */
    public function find(array $conditions);

    /**
     * Get first record matching conditions
     *
     * @param  array  $conditions
     * @return array
     */
    public function findOne(array $conditions);

    /**
     * Insert record
     *
     * @param  array  $record
     * @return bool   True on success, false on failure
     */
    public function insert(array $record);

    /**
     * Delete all records matching conditions
     *
     * @param  array  $conditions
     * @return int    The number of records deleted
     */
    public function delete(array $conditions);

    /**
     * Replace all records matchind conditions
     *
     * @param  array $conditions
     * @param  array $record
     * @return int   The number of records replaces
     */
    public function replace(array $conditions, array $record);

    /**
     * Get the complete record store
     *
     * @return array
     */
    public function getAllRecords();

    /**
     * Get record at index
     *
     * Note that the index of a record may change over time. This method is
     * used when createing indexes, it is not ment as a regular db access
     * method.
     *
     * @param  int   $index
     * @return array
     */
    public function getRecordAt($index);
}
