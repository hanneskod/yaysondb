<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

use hanneskod\yaysondb\Exception\FileNotFoundException;
use hanneskod\yaysondb\Exception\FileModifiedException;
use League\Flysystem\FilesystemInterface;
use Prophecy\Argument;

class FlysystemEngineTest extends \PHPUnit_Framework_TestCase
{
    private function createEngine(array $content = [], string $fname = 'fname'): FlysystemEngine
    {
        $flysystem = $this->prophesize(FilesystemInterface::CLASS);
        $flysystem->has($fname)->willReturn(true);
        $flysystem->read($fname)->willReturn('raw-content');

        $decoder = $this->prophesize(DecoderInterface::CLASS);
        $decoder->decode('raw-content')->willReturn($content);

        return new FlysystemEngine(
            $fname,
            $flysystem->reveal(),
            $decoder->reveal()
        );
    }

    public function testGetId()
    {
        $this->assertSame(
            'foobar',
            $this->createEngine([], 'foobar')->getId()
        );
    }

    public function testIteration()
    {
        $this->assertSame(
            ['foo', 'bar'],
            iterator_to_array($this->createEngine(['foo', 'bar']))
        );
    }

    public function testReading()
    {
        $engine = $this->createEngine(['foo' => ['bar']]);

        $this->assertFalse($engine->has('does-not-exist'));

        $this->assertSame(
            [],
            $engine->read('does-not-exist')
        );

        $this->assertTrue($engine->has('foo'));

        $this->assertSame(
            ['bar'],
            $engine->read('foo')
        );
    }

    public function testThatReadAlwaysReturnsArrays()
    {
        $this->assertSame(
            ['bar'],
            $this->createEngine(['foo' => 'bar'])->read('foo')
        );
    }

    public function testWriteUsingKnownId()
    {
        $engine = $this->createEngine([]);

        $this->assertFalse($engine->inTransaction());

        $id = $engine->write('baz', ['baz']);

        $this->assertSame('baz', $id);

        $this->assertTrue($engine->inTransaction());

        $this->assertSame(
            ['baz'],
            $engine->read($id)
        );
    }

    public function testWriteUsingUnknownId()
    {
        $engine = $this->createEngine([]);

        $this->assertFalse($engine->inTransaction());

        $id = $engine->write('', ['baz']);

        $this->assertSame('0', $id);

        $this->assertTrue($engine->inTransaction());

        $this->assertSame(
            ['baz'],
            $engine->read($id)
        );
    }

    public function testDeleteUnknownDocument()
    {
        $engine = $this->createEngine([]);
        $this->assertFalse($engine->inTransaction());
        $this->assertFalse($engine->delete('does-not-exist'));
        $this->assertFalse($engine->inTransaction());
    }

    public function testDeleteDocument()
    {
        $engine = $this->createEngine(['foo' => []]);
        $this->assertTrue($engine->has('foo'));
        $this->assertFalse($engine->inTransaction());
        $this->assertTrue($engine->delete('foo'));
        $this->assertFalse($engine->has('foo'));
        $this->assertTrue($engine->inTransaction());
    }

    public function testClear()
    {
        $engine = $this->createEngine(['foo' => []]);
        $this->assertTrue($engine->has('foo'));
        $this->assertFalse($engine->inTransaction());
        $engine->clear();
        $this->assertFalse($engine->has('foo'));
        $this->assertTrue($engine->inTransaction());
    }

    public function testExceptionOnUnreadableSource()
    {
        $flysystem = $this->prophesize(FilesystemInterface::CLASS);
        $flysystem->has('foobar')->willReturn(false);

        $this->setExpectedException(FileNotFoundException::CLASS);
        new FlysystemEngine('foobar', $flysystem->reveal());
    }

    public function testExceptionOnChangedSourceContent()
    {
        $flysystem = $this->prophesize(FilesystemInterface::CLASS);
        $flysystem->has(Argument::any())->willReturn(true);

        // Different source is returned at each read..
        $count = 0;
        $flysystem->read('fname')->will(function () use (&$count) {
            return (string)$count++;
        });

        $decoder = $this->prophesize(DecoderInterface::CLASS);
        $decoder->decode(Argument::any())->willReturn([]);

        $engine = new FlysystemEngine(
            'fname',
            $flysystem->reveal(),
            $decoder->reveal()
        );

        $this->setExpectedException(FileModifiedException::CLASS);
        $engine->commit();
    }

    public function testCommit()
    {
        $flysystem = $this->prophesize(FilesystemInterface::CLASS);
        $flysystem->has('fname')->willReturn(true);
        $flysystem->read('fname')->willReturn('raw-content');
        $flysystem->update('fname', 'updated-content')->shouldBeCalled();

        $decoder = $this->prophesize(DecoderInterface::CLASS);
        $decoder->decode('raw-content')->willReturn([]);
        $decoder->encode(['foo' => ['bar']])->willReturn('updated-content');

        $engine = new FlysystemEngine(
            'fname',
            $flysystem->reveal(),
            $decoder->reveal()
        );

        $engine->write('foo', ['bar']);

        $this->assertTrue($engine->inTransaction());
        $engine->commit();
        $this->assertFalse($engine->inTransaction());
    }

    public function testGuessPhpMimeType()
    {
        $flysystem = $this->prophesize(FilesystemInterface::CLASS);
        $flysystem->has('data.php')->willReturn(true);
        $flysystem->getMimetype('data.php')->willReturn('application/x-httpd-php');
        $flysystem->read('data.php')->willReturn('<?php return ["item" => ["foo"]];');

        $engine = new FlysystemEngine(
            'data.php',
            $flysystem->reveal()
        );

        $this->assertSame(
            ['foo'],
            $engine->read('item')
        );
    }

    public function testGuessJsonMimeType()
    {
        $flysystem = $this->prophesize(FilesystemInterface::CLASS);
        $flysystem->has('data.json')->willReturn(true);
        $flysystem->getMimetype('data.json')->willReturn('application/json  ');
        $flysystem->read('data.json')->willReturn('{"item": ["foo"]}');

        $engine = new FlysystemEngine(
            'data.json',
            $flysystem->reveal()
        );

        $this->assertSame(
            ['foo'],
            $engine->read('item')
        );
    }
}
