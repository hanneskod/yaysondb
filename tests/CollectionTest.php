<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

class CollectionTest extends \PHPUnit_Framework_TestCase
{
    public function testInvalidJson()
    {
        $this->setExpectedException('hanneskod\yaysondb\Exception\InvalidCollectionException');
        new Collection('not-valid-json');
    }

    public function testExceptionWhenDocumentDoesNotExist()
    {
        $this->setExpectedException('hanneskod\yaysondb\Exception\InvalidDocumentException');
        (new Collection)->getDocument('does-not-exist');
    }

    public function testGetDocument()
    {
        $this->assertSame(
            ['_id' => 'myid'],
            (new Collection('{"myid":{}}'))->getDocument('myid')
        );
    }

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

    public function testInsertIntoEmptyDatabase()
    {
        $collection = new Collection;
        $this->assertSame(0, count($collection));
        $collection->insert([]);
        $this->assertSame(1, count($collection));
    }

    public function testInsertIdHandling()
    {
        $collection = new Collection;
        $this->assertSame(
            'myid',
            $collection->insert(['_id' => 'myid']),
            'Insert should return document _id'
        );
        $this->assertTrue(
            is_numeric($collection->insert([])),
            'Insert should create numerical _id if document _id is not set'
        );
    }

    public function testInsertExceptionWithNonscalarId()
    {
        $this->setExpectedException('hanneskod\yaysondb\Exception\InvalidDocumentException');
        (new Collection)->insert(['_id' => []]);
    }

    public function testInsertExceptionWithEmptyId()
    {
        $this->setExpectedException('hanneskod\yaysondb\Exception\InvalidDocumentException');
        (new Collection)->insert(['_id' => '']);
    }

    public function testInsertExceptionWhenDocumentExists()
    {
        $this->setExpectedException('hanneskod\yaysondb\Exception\DocumentDuplicationException');
        $collection = new Collection;
        $collection->insert(['_id' => 'foo']);
        $collection->insert(['_id' => 'foo']);
    }

    public function testUpdate()
    {
        $expr = $this->createMock('hanneskod\yaysondb\Expr');
        $expr->expects($this->once())
            ->method('evaluate')
            ->will($this->returnValue(true));

        $collection = new Collection;

        $collection->insert(
            [
                "_id" => "myid",
                "name" => "foobar",
                "phone" => "xxx",
                "embed" => [
                    "foo" => "foo",
                    "bar" => "bar"
                ]
            ]
        );

        $collection->update(
            $expr,
            [
                "phone" => "123456",
                "embed" => [
                    "foo" => "bar",
                    "added" => "added"
                ]
            ]
        );

        $this->assertEquals(
            [
                "_id" => "myid",
                "name" => "foobar",
                "phone" => "123456",
                "embed" => [
                    "foo" => "bar",
                    "bar" => "bar",
                    "added" => "added"
                ]
            ],
            $collection->getDocument('myid')
        );
    }

    public function testUpdateDocumentId()
    {
        $expr = $this->createMock('hanneskod\yaysondb\Expr');
        $expr->expects($this->once())
            ->method('evaluate')
            ->will($this->returnValue(true));

        $collection = new Collection;

        $collection->insert(["_id" => "foo"]);

        $this->assertTrue($collection->containsDocument('foo'));
        $this->assertFalse($collection->containsDocument('bar'));

        $collection->update($expr, ["_id" => "bar"]);

        $this->assertFalse($collection->containsDocument('foo'));
        $this->assertTrue($collection->containsDocument('bar'));
    }

    public function testUpdateExceptionWhenDocumentExists()
    {
        $expr = $this->createMock('hanneskod\yaysondb\Expr');
        $expr->expects($this->once())
            ->method('evaluate')
            ->will($this->returnValue(true));

        $this->setExpectedException('hanneskod\yaysondb\Exception\DocumentDuplicationException');
        $collection = new Collection;
        $collection->insert(["_id" => "foo"]);
        $collection->insert(["_id" => "bar"]);
        $collection->update($expr, ["_id" => "bar"]);
    }

    public function testDeletingDocuments()
    {
        $doc = ['_id' => 'myid'];
        $docJson = '{"myid":{}}';

        $expr = $this->createMock('hanneskod\yaysondb\Expr');
        $expr->expects($this->once())
            ->method('evaluate')
            ->with($doc)
            ->will($this->returnValue(true));

        $collection = new Collection($docJson);

        $this->assertSame(1, count($collection));

        $this->assertSame(
            1,
            $collection->delete($expr),
            'Delete should return the number of deleted documents'
        );

        $this->assertSame(0, count($collection));
    }

    public function testJsonSerialize()
    {
        $json = '{"1":{"name":"foo"},"2":{"name":"bar"}}';
        $this->assertSame(
            $json,
            json_encode(new Collection($json))
        );
    }
}
