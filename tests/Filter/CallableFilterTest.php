<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Filter;

class CallableFilterTest extends \PHPUnit_Framework_TestCase
{
    public function testFilter()
    {
        $filter = new CallableFilter(function ($arg) {
            return $arg % 2 == 0;
        });

        $this->assertEquals(
            [2, 4],
            array_values(iterator_to_array(
                $filter->filter(new \ArrayIterator([1, 2, 3, 4]))
            ))
        );
    }
}
