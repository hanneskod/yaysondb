<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Filter;

class OrderByTest extends \PHPUnit_Framework_TestCase
{
    public function testOrderBySingleKey()
    {
        $iter = new OrderBy('name');

        $iter->setIterator(new \ArrayIterator([
            'B' => ['name' => 'B'],
            'A' => ['name' => 'A'],
            'C' => ['name' => 'C']
        ]));

        $keys = '';
        foreach ($iter as $id => $doc) {
            $keys .= $id;
        }

        $this->assertEquals(
            'ABC',
            $keys
        );
    }

    public function testOrderByDoubbleKeys()
    {
        $iter = new OrderBy('name', 'age');

        $iter->setIterator(new \ArrayIterator([
            'C30' => ['name' => 'C', 'age' => 30],
            'A30' => ['name' => 'A', 'age' => 30],
            'A20' => ['name' => 'A', 'age' => 20],
            'A10' => ['name' => 'A', 'age' => 10]
        ]));

        $keys = '';
        foreach ($iter as $id => $doc) {
            $keys .= $id;
        }

        $this->assertEquals(
            'A10A20A30C30',
            $keys
        );
    }
}
