<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Filter;

class LimitFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testCount()
    {
        $limit = new LimitFilter(2);
        $this->assertSame(
            [0 => 'A', 1 => 'B'],
            iterator_to_array($limit->filter(new \ArrayIterator([0 => 'A', 1 => 'B', 2 => 'C'])))
        );
    }

    public function testOffset()
    {
        $limit = new LimitFilter(1, 1);
        $this->assertSame(
            [1 => 'B'],
            iterator_to_array($limit->filter(new \ArrayIterator([0 => 'A', 1 => 'B', 2 => 'C'])))
        );
    }
}
