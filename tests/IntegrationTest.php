<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Operators as y;
use hanneskod\yaysondb\Engine\FlysystemEngine;
use hanneskod\yaysondb\Engine\JsonDecoder;
use League\Flysystem\Filesystem;
use League\Flysystem\Memory\MemoryAdapter;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    private function createDatabase(): Yaysondb
    {
        $fs = new Filesystem(new MemoryAdapter);
        $fs->write('data', '');

        return new Yaysondb([
            'data' => new Collection(
                new FlysystemEngine(
                    'data',
                    $fs,
                    new JsonDecoder
                )
            )
        ]);
    }

    public function testFilterName()
    {
        $db = $this->createDatabase();

        $db->data->insert(['name' => 'D']);
        $db->data->insert(['no-name' => 'foo']);
        $db->data->insert(['name' => 'C']);
        $db->data->insert(['name' => 'B']);
        $db->data->insert(['name' => 'A']);

        $this->assertCount(5, $db->data);

        $this->assertSame(
            [['name' => 'B'], ['name' => 'C']],
            iterator_to_array(
                $db->data->find(y::doc(['name' => y::exists()]))->orderBy('name')->limit(2, 1)
            )
        );
    }

    public function testFindAddressesInMalmo()
    {
        $db = $this->createDatabase();

        $db->data->insert([
            "name" => "Ebbe",
            "address" => [
                "town" => "Malmo"
            ]
        ]);

        $db->data->insert([
            "name" => "Emmy",
            "address" => [
                "town" => "Goteborg"
            ]
        ]);

        $this->assertSame(
            'Ebbe',
            $db->data->find(y::doc([
                'address' => y::doc([
                    'town' => y::regexp('/malmo/i')
                ])
            ]))->first()['name']
        );
    }

    public function testUpdate()
    {
        $db = $this->createDatabase();

        $id = $db->data->insert(['name' => 'foo']);
        $count = $db->data->update(y::doc(['name' => y::exists()]), ['age' => 10]);

        $this->assertSame(1, $count);

        $this->assertSame(
            [
                'name' => 'foo',
                'age' => 10
            ],
            $db->data->read($id)
        );
    }
}
