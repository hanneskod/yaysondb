<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Engine\EngineInterface;
use hanneskod\yaysondb\Exception\LogicException;
use Prophecy\Argument;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testExceptionOnReadingUnknownDocument()
    {
        $engine = $this->prophesize(EngineInterface::CLASS);
        $engine->has('foo')->willReturn(false);

        $this->setExpectedException(LogicException::CLASS);
        (new Collection($engine->reveal()))->read('foo');
    }

    public function testRead()
    {
        $engine = $this->prophesize(EngineInterface::CLASS);
        $engine->has('foo')->willReturn(true);
        $engine->read('foo')->willReturn(['bar']);

        $this->assertSame(
            ['bar'],
            (new Collection($engine->reveal()))->read('foo')
        );
    }

    public function testInsert()
    {
        $engine = $this->prophesize(EngineInterface::CLASS);
        $engine->write('', ['foo'])->willReturn('id')->shouldBeCalled();

        $this->assertSame(
            'id',
            (new Collection($engine->reveal()))->insert(['foo'])
        );
    }

    public function testUpdate()
    {
        $engine = $this->prophesize(EngineInterface::CLASS);

        $engine->getIterator()->willReturn(new \ArrayIterator([
            '0' => ['name' => 'foo']
        ]));

        $engine->write('0', ['name' => 'foo', 'bar' => 'baz'])->shouldBeCalled();

        $expr = $this->prophesize(Expression\ExpressionInterface::CLASS);
        $expr->evaluate(Argument::any())->willReturn(true);

        $count = (new Collection($engine->reveal()))->update($expr->reveal(), ['bar' => 'baz']);

        $this->assertSame(1, $count);
    }

    public function testDelete()
    {
        $engine = $this->prophesize(EngineInterface::CLASS);

        $engine->getIterator()->willReturn(new \ArrayIterator(['0' => []]));

        $engine->delete('0')->willReturn(true)->shouldBeCalled();

        $expr = $this->prophesize(Expression\ExpressionInterface::CLASS);
        $expr->evaluate(Argument::any())->willReturn(true);

        $count = (new Collection($engine->reveal()))->delete($expr->reveal());

        $this->assertSame(1, $count);
    }

    public function testCommit()
    {
        $engine = $this->prophesize(EngineInterface::CLASS);
        $engine->commit()->shouldBeCalled();

        (new Collection($engine->reveal()))->commit();
    }

    public function testInTransaction()
    {
        $engine = $this->prophesize(EngineInterface::CLASS);
        $engine->inTransaction()->willReturn(true)->shouldBeCalled();

        $this->assertTrue(
            (new Collection($engine->reveal()))->inTransaction()
        );
    }

    public function testReset()
    {
        $engine = $this->prophesize(EngineInterface::CLASS);
        $engine->reset()->shouldBeCalled();

        (new Collection($engine->reveal()))->reset();
    }
}
