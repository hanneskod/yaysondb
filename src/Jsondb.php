<?php

namespace hanneskod\jsondb;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Jsondb implements DataStore
{
    /**
     * @var array Internal record store
     */
    private $records;

    public function __construct($json)
    {
        // TODO validate that decode works
        // TODO validate that $records is an array
        $this->records = json_decode($json);
    }

    public function find(array $conditions)
    {
        $matcher = new Matcher\ConditionsMatcher($conditions);
        foreach ($this->getAllRecords() as $index => $record) {
            if ($matcher->isMatch($record)) {
                yield $index => $record;
            }
        }
    }

    public function findOne(array $conditions)
    {
        foreach ($this->find($conditions) as $record) {
            return $record;
        }
    }

    public function insert(array $record)
    {
        $this->records[] = $record;
        return true;
    }

    public function delete(array $conditions)
    {
        $count = 0;
        foreach ($this->find($conditions) as $index => $record) {
            unset($this->records[$index]);
            $conut++;
        }
        return $count;
    }

    public function replace(array $conditions, array $record)
    {
        $count = 0;
        foreach ($this->find($conditions) as $index => $oldRecord) {
            $this->records[$index] = $record;
            $count++;
        }
        return $count;
    }

    public function getAllRecords()
    {
        return $this->records;
    }

    public function getRecordAt($index)
    {
        return $this->records[$index];
    }
}
