<?php

namespace hanneskod\yaysondb\Filter;

class LimitTest extends \PHPUnit_Framework_TestCase
{
    public function testCount()
    {
        $limit = new Limit(2);
        $limit->setIterator(new \ArrayIterator(['A', 'B', 'C']));
        $this->assertSame(
            'AB',
            implode('', iterator_to_array($limit))
        );
    }

    public function testOffset()
    {
        $limit = new Limit(2, 1);
        $limit->setIterator(new \ArrayIterator(['A', 'B', 'C']));
        $this->assertSame(
            'BC',
            implode('', iterator_to_array($limit))
        );
    }

    public function testCountAndOffset()
    {
        $limit = new Limit(3, 2);
        $limit->setIterator(new \ArrayIterator(['A', 'B', 'C', 'D', 'E', 'F', 'G']));
        $this->assertSame(
            'CDE',
            implode('', iterator_to_array($limit))
        );
    }
}
