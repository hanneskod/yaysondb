<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Filter;

use hanneskod\yaysondb\MockFactoryTrait;

class ExpressionFilterTest extends \PHPUnit_Framework_TestCase
{
    use MockFactoryTrait;

    public function testFilterAll()
    {
        $data = ['A', 'B', 'C'];
        $this->assertEquals(
            $data,
            iterator_to_array(
                (new ExpressionFilter($this->createExpressionMock(true)))->filter(new \ArrayIterator($data))
            )
        );
    }

    public function testFilterNone()
    {
        $data = ['A', 'B', 'C'];
        $this->assertEquals(
            [],
            iterator_to_array(
                (new ExpressionFilter($this->createExpressionMock(false)))->filter(new \ArrayIterator($data))
            )
        );
    }
}
