<?php

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Expressions as y;

class IntegrationTest extends \PHPUnit_Framework_TestCase
{
    public function testVoid()
    {
    }

    /*
    public function testIntegration()
    {
        $db = new Yaysondb(new DirectoryAdapter(__DIR__));

        $doc = $db->testdata->findOne(
            y::doc(
                [
                    'name' => y::equals('foo')
                ]
            )
        );

        print_r($doc);
    }
    //*/
}
