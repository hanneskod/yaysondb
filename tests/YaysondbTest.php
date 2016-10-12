<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Engine\EngineInterface;

class YaysondbTest extends \PHPUnit_Framework_TestCase
{
    public function testLoad()
    {
        $engineProphecy = $this->prophesize(EngineInterface::CLASS);
        $engineProphecy->getId()->willReturn('foobar');
        $engine = $engineProphecy->reveal();

        $db = new Yaysondb;

        $db->load($engine, 'handle');

        $this->assertTrue(
            $db->hasCollection('handle')
        );

        $this->assertEquals(
            new Collection($engine),
            $db->collection('handle')
        );

        $db->load($engine);

        $this->assertEquals(
            new Collection($engine),
            $db->collection('foobar')
        );

        $this->assertTrue(
            $db->hasCollection('foobar')
        );

        $this->assertTrue(
            isset($db->foobar)
        );
    }

    public function testLoadAtConstruct()
    {
        $engineProphecyA = $this->prophesize(EngineInterface::CLASS);
        $engineProphecyA->getId()->willReturn('A');
        $engineA = $engineProphecyA->reveal();

        $engineProphecyB = $this->prophesize(EngineInterface::CLASS);
        $engineProphecyB->getId()->willReturn('B');
        $engineB = $engineProphecyB->reveal();

        $db = new Yaysondb([$engineA, 'C' => $engineB]);

        $this->assertEquals(
            new Collection($engineA),
            $db->collection('A')
        );

        $this->assertEquals(
            new Collection($engineB),
            $db->C
        );
    }

    public function testExceptionOnUnknownCollection()
    {
        $this->setExpectedException(Exception\LogicException::CLASS);
        (new Yaysondb)->collection('does-not-exist');
    }

    public function testCommit()
    {
        $engineA = $this->prophesize(EngineInterface::CLASS);
        $engineA->inTransaction()->willReturn(false);
        $engineA->commit()->shouldNotBeCalled();

        $engineB = $this->prophesize(EngineInterface::CLASS);
        $engineB->inTransaction()->willReturn(true);
        $engineB->commit()->shouldBeCalled();

        (new Yaysondb(['A' => $engineA->reveal(), 'B' => $engineB->reveal()]))->commit();
    }

    public function testInTransaction()
    {
        $fresh = $this->prophesize(EngineInterface::CLASS);
        $fresh->inTransaction()->willReturn(false);

        $trans = $this->prophesize(EngineInterface::CLASS);
        $trans->inTransaction()->willReturn(true);

        $this->assertFalse(
            (new Yaysondb(['A' => $fresh->reveal(), 'B' => $fresh->reveal()]))->inTransaction()
        );

        $this->assertTrue(
            (new Yaysondb(['A' => $fresh->reveal(), 'B' => $trans->reveal()]))->inTransaction()
        );
    }

    public function testReset()
    {
        $engineA = $this->prophesize(EngineInterface::CLASS);
        $engineA->inTransaction()->willReturn(false);
        $engineA->reset()->shouldNotBeCalled();

        $engineB = $this->prophesize(EngineInterface::CLASS);
        $engineB->inTransaction()->willReturn(true);
        $engineB->reset()->shouldBeCalled();

        (new Yaysondb(['A' => $engineA->reveal(), 'B' => $engineB->reveal()]))->reset();
    }
}
