<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

use hanneskod\yaysondb\Exception\LogicException;

class LogEngineTest extends \PHPUnit\Framework\TestCase
{
    public function testGetId()
    {
        $this->assertSame(
            'php://memory',
            (new LogEngine('php://memory'))->getId()
        );
    }
    public function testExceptionOnWritingUsingId()
    {
        $this->expectException(LogicException::CLASS);
        (new LogEngine('php://memory'))->write('id', []);
    }

    public function testWrite()
    {
        $engine = new LogEngine('php://memory');
        $this->assertFalse($engine->inTransaction());
        $engine->write('', []);
        $this->assertTrue($engine->inTransaction());
        $engine->reset();
        $this->assertFalse($engine->inTransaction());
    }

    public function testCommitAndIterate()
    {
        $engine = new LogEngine('php://memory');

        $engine->write('', ['foo']);
        $engine->write('', ['bar']);

        $this->assertTrue($engine->inTransaction());
        $engine->commit();
        $this->assertFalse($engine->inTransaction());

        $this->assertSame(
            [['foo'], ['bar']],
            iterator_to_array($engine)
        );
    }

    public function testIterateNonCommitedContent()
    {
        $engine = new LogEngine('php://memory');

        $engine->write('', ['foo']);
        $engine->write('', ['bar']);

        $this->assertSame(
            [['foo'], ['bar']],
            iterator_to_array($engine)
        );
    }

    public function testHasNotSupported()
    {
        $this->expectException(LogicException::CLASS);
        (new LogEngine('php://memory'))->has('');
    }

    public function testReadNotSupported()
    {
        $this->expectException(LogicException::CLASS);
        (new LogEngine('php://memory'))->read('');
    }

    public function testDeleteNotSupported()
    {
        $this->expectException(LogicException::CLASS);
        (new LogEngine('php://memory'))->delete('');
    }

    public function testClearNotSupported()
    {
        $this->expectException(LogicException::CLASS);
        (new LogEngine('php://memory'))->clear();
    }
}
