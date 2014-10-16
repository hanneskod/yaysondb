<?php

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Operators as y;

class OperatorsTest extends \PHPUnit_Framework_TestCase
{
    public function testDoc()
    {
        $doc = y::doc(['key' => $this->createTrueExpr()]);

        $this->assertTrue(
            $doc->evaluate(['key' => 'void']),
            'Internal expressions returns true'
        );
        $this->assertFalse(
            $doc->evaluate([]),
            'Key does not exist'
        );
        $this->assertFalse(
            $doc->evaluate('string'),
            'Operand is not an array'
        );

        $this->assertFalse(
            y::doc(['key' => $this->createFalseExpr()])->evaluate(['key' => 'void']),
            'Internal expressions returns false'
        );
    }

    public function testDocNotAnExpressionException()
    {
        $this->setExpectedException('hanneskod\yaysondb\Exception\InvalidArgumentException');
        y::doc(['key' => 'not-an-expression']);
    }

    public function testExistsAndNot()
    {
        $this->assertTrue(
            y::exists()->evaluate(''),
            'Exists should always evaluate to true'
        );
        $this->assertFalse(
            y::not(y::exists())->evaluate(''),
            'Not negates contained expression'
        );
    }

    public function testType()
    {
        $this->assertTrue(
            y::type('string')->evaluate('asdf')
        );
        $this->assertFalse(
            y::type('int')->evaluate('sf')
        );
    }

    public function testIn()
    {
        $this->assertTrue(
            y::in(['foo', 'bar'])->evaluate('foo')
        );
        $this->assertFalse(
            y::in(['foo', 'bar'])->evaluate('foobar')
        );
    }

    public function testRegexp()
    {
        $this->assertTrue(
            y::regexp('/foo/')->evaluate('foo')
        );
        $this->assertFalse(
            y::regexp('/foo/')->evaluate('bar')
        );
    }

    public function testEqualsAndSame()
    {
        $this->assertTrue(
            y::equals((object)['foo' => 'bar'])->evaluate((object)['foo' => 'bar']),
            'Two objects with the same content equals each other'
        );
        $this->assertFalse(
            y::same((object)['foo' => 'bar'])->evaluate((object)['foo' => 'bar']),
            'Two objects with the same content are not the same object'
        );
    }

    public function testGreaterAndLessThan()
    {
        $this->assertTrue(
            y::greaterThan(5)->evaluate(6),
            '6 is greater than 5'
        );
        $this->assertTrue(
            y::greaterThanOrEquals(5)->evaluate(5),
            '5 is greater than or equals 5'
        );
        $this->assertTrue(
            y::lessThan(5)->evaluate(4),
            '4 is less than 5'
        );
        $this->assertFalse(
            y::lessThan(5)->evaluate(5),
            '5 is not less than 5'
        );
        $this->assertTrue(
            y::lessThanOrEquals(5)->evaluate(5),
            '5 is less than or equals 5'
        );
    }

    public function testAll()
    {
        $this->assertTrue(
            y::all($this->createTrueExpr(), $this->createTrueExpr())->evaluate('')
        );
        $this->assertFalse(
            y::all($this->createTrueExpr(), $this->createFalseExpr())->evaluate('')
        );
    }

    public function testAtLeastOne()
    {
        $this->assertTrue(
            y::atLeastOne($this->createTrueExpr(), $this->createFalseExpr())->evaluate('')
        );
        $this->assertFalse(
            y::atLeastOne($this->createFalseExpr(), $this->createFalseExpr())->evaluate('')
        );
    }

    public function testExactly()
    {
        $this->assertTrue(
            y::exactly(2, $this->createTrueExpr(), $this->createTrueExpr())->evaluate('')
        );
        $this->assertFalse(
            y::exactly(2, $this->createTrueExpr(), $this->createFalseExpr())->evaluate('')
        );
    }

    public function testNone()
    {
        $this->assertTrue(
            y::none($this->createFalseExpr(), $this->createFalseExpr())->evaluate('')
        );
        $this->assertFalse(
            y::none($this->createTrueExpr(), $this->createFalseExpr())->evaluate('')
        );
    }

    public function testOne()
    {
        $this->assertTrue(
            y::one($this->createTrueExpr(), $this->createFalseExpr())->evaluate('')
        );
        $this->assertFalse(
            y::one($this->createTrueExpr(), $this->createTrueExpr())->evaluate('')
        );
    }

    public function testListAll()
    {
        $this->assertTrue(
            y::listAll(y::type('string'))->evaluate([
                'a string',
                'another string'
            ])
        );
        $this->assertFalse(
            y::listAll(y::type('string'))->evaluate([
                'a string',
                1233
            ])
        );
        $this->assertFalse(
            y::listAll(y::type('string'))->evaluate('not-a-string'),
            'Evaluate argument must be an array'
        );
    }

    public function testListAtLeastOne()
    {
        $this->assertTrue(
            y::listAtLeastOne(y::type('string'))->evaluate([
                'a string',
                'another string'
            ])
        );
        $this->assertFalse(
            y::listAtLeastOne(y::type('string'))->evaluate([
                1234,
                1233
            ])
        );
        $this->assertFalse(
            y::listAtLeastOne(y::type('string'))->evaluate('not-a-string'),
            'Evaluate argument must be an array'
        );
    }

    public function testListExactly()
    {
        $this->assertTrue(
            y::listExactly(2, y::type('string'))->evaluate([
                'a string',
                'another string'
            ])
        );
        $this->assertFalse(
            y::listExactly(2, y::type('string'))->evaluate([
                'a string',
                1233
            ])
        );
        $this->assertFalse(
            y::listExactly(2, y::type('string'))->evaluate('not-a-string'),
            'Evaluate argument must be an array'
        );
    }

    public function testListNone()
    {
        $this->assertTrue(
            y::listNone(y::type('string'))->evaluate([
                1231,
                23423
            ])
        );
        $this->assertFalse(
            y::listNone(y::type('string'))->evaluate([
                'a string',
                1233
            ])
        );
    }

    public function testListOne()
    {
        $this->assertTrue(
            y::listOne(y::type('string'))->evaluate([
                'a string',
                23423
            ])
        );
        $this->assertFalse(
            y::listOne(y::type('string'))->evaluate([
                'a string',
                'another string'
            ])
        );
    }

    private function createTrueExpr()
    {
        $expr = $this->getMock('\hanneskod\yaysondb\Expr');
        $expr->expects($this->any())
            ->method('evaluate')
            ->will($this->returnValue(true));
        return $expr;
    }

    private function createFalseExpr()
    {
        $expr = $this->getMock('\hanneskod\yaysondb\Expr');
        $expr->expects($this->any())
            ->method('evaluate')
            ->will($this->returnValue(false));
        return $expr;
    }
}
