<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

class YaysondbTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCollection()
    {
        $collection = $this->createMock(CollectionInterface::CLASS);

        $db = new Yaysondb(['foo' => $collection]);

        $this->assertSame(
            $collection,
            $db->collection('foo')
        );

        $this->assertSame(
            $collection,
            $db->foo
        );
    }

    public function testExceptionOnUnknownCollection()
    {
        $this->setExpectedException(Exception\LogicException::CLASS);
        (new Yaysondb([]))->collection('does-not-exist');
    }

    public function testCommit()
    {
        $collA = $this->prophesize(CollectionInterface::CLASS);
        $collA->inTransaction()->willReturn(false);
        $collA->commit()->shouldNotBeCalled();

        $collB = $this->prophesize(CollectionInterface::CLASS);
        $collB->inTransaction()->willReturn(true);
        $collB->commit()->shouldBeCalled();

        (new Yaysondb([$collA->reveal(), $collB->reveal()]))->commit();
    }

    public function testInTransaction()
    {
        $fresh = $this->prophesize(CollectionInterface::CLASS);
        $fresh->inTransaction()->willReturn(false);

        $trans = $this->prophesize(CollectionInterface::CLASS);
        $trans->inTransaction()->willReturn(true);

        $this->assertFalse(
            (new Yaysondb([$fresh->reveal(), $fresh->reveal()]))->inTransaction()
        );

        $this->assertTrue(
            (new Yaysondb([$fresh->reveal(), $trans->reveal()]))->inTransaction()
        );
    }

    public function testReset()
    {
        $collA = $this->prophesize(CollectionInterface::CLASS);
        $collA->inTransaction()->willReturn(false);
        $collA->reset()->shouldNotBeCalled();

        $collB = $this->prophesize(CollectionInterface::CLASS);
        $collB->inTransaction()->willReturn(true);
        $collB->reset()->shouldBeCalled();

        (new Yaysondb([$collA->reveal(), $collB->reveal()]))->reset();
    }
}
