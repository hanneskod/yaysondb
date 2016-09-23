<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Operators as y;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function testFilterSetX()
    {
        $this->assertEquals(
            'setX_DsetX_E',
            $this->flattenNames(
                $this->getDB()->testdata
                    ->find(y::doc(['setX' => y::exists()]))
                    ->orderBy('name')
                    ->limit(3, 3)
            )
        );
    }

    public function testFindAddressesInMalmo()
    {
        $this->assertEquals(
            'Ebbe',
            $this->flattenNames(
                $this->getDB()->testdata->find(
                    y::doc([
                        'address' => y::doc([
                            'town' => y::regexp('/malmo/i')
                        ])
                    ])
                )
            )
        );
    }

    public function testFindMiscAllStrings()
    {
        $this->assertEquals(
            'Emmy',
            $this->flattenNames(
                $this->getDB()->testdata->find(
                    y::doc([
                        'misc' => y::listAll(
                            y::type('string')
                        )
                    ])
                )
            )
        );
    }

    private function getDB()
    {
        if (!isset($this->db)) {
            $this->db = new Yaysondb(new Adapter\DirectoryAdapter(__DIR__));
        }
        return $this->db;
    }

    private function flattenNames(DocumentSet $set)
    {
        $names = '';
        foreach ($set as $doc) {
            $names .= $doc['name'];
        }
        return $names;
    }
}
