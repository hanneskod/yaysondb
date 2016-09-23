<?php

namespace hanneskod\yaysondb;

class YaysondbTest extends \PHPUnit_Framework_TestCase
{
    public function testGetCollection()
    {
        $adapter = $this->createMock('hanneskod\yaysondb\Adapter');
        $adapter->expects($this->once())
            ->method('read')
            ->with('mycollection')
            ->will($this->returnValue('[]'));

        $db = new Yaysondb($adapter);

        $this->assertSame(
            $db->collection('mycollection'),
            $db->mycollection
        );
    }

    public function testCommitCollection()
    {
        $adapter = $this->createMock('hanneskod\yaysondb\Adapter');
        $adapter->expects($this->once())
            ->method('read')
            ->with('mycollection')
            ->will($this->returnValue('[]'));
        $adapter->expects($this->once())
            ->method('write')
            ->with('mycollection');

        $db = new Yaysondb($adapter);
        $db->commit('mycollection');
    }
}
