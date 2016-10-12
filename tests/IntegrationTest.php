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
    private static $decoderClasses = [
        Engine\JsonDecoder::CLASS,
        Engine\PhpDecoder::CLASS,
        Engine\SerializingDecoder::CLASS
    ];

    public function dbProvider()
    {
        $menory = new Filesystem(new MemoryAdapter);

        foreach (self::$decoderClasses as $decoderClass) {
            $menory->put('data', '');
            yield [
                new Yaysondb([new FlysystemEngine('data', $menory, new $decoderClass)])
            ];
        }
    }

    /**
     * @dataProvider dbProvider
     */
    public function testFilterName(Yaysondb $db)
    {
        $db->data->insert(['name' => 'D']);
        $db->data->insert(['no-name' => 'foo']);
        $db->data->insert(['name' => 'C']);
        $db->data->insert(['name' => 'B']);
        $db->data->insert(['name' => 'A']);

        $this->assertCount(5, $db->data);

        $result = $db->data->find(y::doc(['name' => y::exists()]))->orderBy('name')->limit(2, 1);

        $this->assertSame(
            [['name' => 'B'], ['name' => 'C']],
            iterator_to_array($result)
        );
    }

    /**
     * @dataProvider dbProvider
     */
    public function testFindAddressesInMalmo(Yaysondb $db)
    {
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

    /**
     * @dataProvider dbProvider
     */
    public function testUpdate(Yaysondb $db)
    {
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
