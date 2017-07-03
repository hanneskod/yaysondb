<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

use Prophecy\Argument;

class FilterableTest extends \PHPUnit\Framework\TestCase
{
    public function testCount()
    {
        $this->assertCount(2, new Filterable(new \ArrayIterator([1, 2])));
    }

    public function testIteration()
    {
        $this->assertSame(
            [1, 2],
            iterator_to_array(new Filterable(new \ArrayIterator([1, 2])))
        );
    }

    public function testEach()
    {
        $sum = 0;

        (new Filterable(new \ArrayIterator([1, 2])))->each(function ($int) use (&$sum) {
            $sum += $int;
        });

        $this->assertSame(3, $sum);
    }

    public function testFirst()
    {
        $this->assertSame(
            [1],
            (new Filterable(new \ArrayIterator([1, 2])))->first()
        );

        $this->assertSame(
            [],
            (new Filterable(new \ArrayIterator([])))->first()
        );
    }

    public function testIsEmpty()
    {
        $this->assertFalse(
            (new Filterable(new \ArrayIterator([1, 2])))->isEmpty()
        );

        $this->assertTrue(
            (new Filterable(new \ArrayIterator([])))->isEmpty()
        );
    }

    public function testLimit()
    {
        $this->assertSame(
            [1],
            iterator_to_array(
                (new Filterable(new \ArrayIterator([1, 2])))->limit(1, 0)
            )
        );
    }

    public function testOrderBy()
    {
        $this->assertSame(
            [['name' => 'A'], ['name' => 'B']],
            iterator_to_array(
                (new Filterable(new \ArrayIterator([['name' => 'B'], ['name' => 'A']])))->orderBy('name')
            )
        );
    }

    public function testWhere()
    {
        $this->assertSame(
            [1],
            iterator_to_array(
                (new Filterable(new \ArrayIterator([1, 'A'])))->where('is_int')
            )
        );
    }

    public function testFindOne()
    {
        $expr = $this->prophesize(Expression\ExpressionInterface::CLASS);
        $expr->evaluate(Argument::any())->willReturn(true);

        $this->assertSame(
            [1],
            (new Filterable(new \ArrayIterator([1, 2])))->findOne($expr->reveal())
        );
    }

    /*
    public function testFindoneReturnsArrayIfNoMatch()
    {
        $this->assertSame(
            [],
            (new Collection)->findOne(
                $this->createMock('hanneskod\yaysondb\Expr')
            ),
            'FindOne should return [] if no document match'
        );
    }

    public function testFindOneDocument()
    {
        $doc = ['_id' => 'myid'];
        $docJson = '{"myid":{}}';

        $expr = $this->createMock('hanneskod\yaysondb\Expr');
        $expr->expects($this->once())
            ->method('evaluate')
            ->with($doc)
            ->will($this->returnValue(true));

        $this->assertSame(
            $doc,
            (new Collection($docJson))->findOne($expr),
            'FindOne should return found document directly'
        );
    }
    //*/
}
