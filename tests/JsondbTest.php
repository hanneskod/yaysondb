<?php

namespace hanneskod\jsondb;

use hanneskod\jsondb\Matchers as M;

class JsondbTest extends \PHPUnit_Framework_TestCase
{
    public function testFind()
    {
        $db = new Jsondb(<<<JSON
[
    {
        "id": "1",
        "name": "nn"
    },
    {
        "id": "2",
        "name": "nn"
    }
]
JSON
);

        $this->assertEquals(
            (object)['id' => '2', 'name' => 'nn'],
            iterator_to_array(
                $db->find([
                    "id" => M::greaterThan(1),
                    'name' => M::equals('nn')
                ])
            )[1]
        );
    }
}
