<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Adapter;

class DirectoryAdapterTest extends \PHPUnit_Framework_TestCase
{
    public function testDirectoryAdapter()
    {
        $adapter = new DirectoryAdapter(sys_get_temp_dir());
        $adapter->write('handle', 'my content');
        $this->assertSame(
            'my content',
            $adapter->read('handle')
        );
        unlink(sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'handle.json');
    }

    public function testNotReadableFileException()
    {
        $this->setExpectedException('hanneskod\yaysondb\Exception\AdapterException');
        $adapter = new DirectoryAdapter(__DIR__);
        $adapter->read('this-file-does-not-exist');
    }
}
