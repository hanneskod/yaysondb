<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

abstract class AbstractsonDecorderTest extends \PHPUnit\Framework\TestCase
{
    abstract protected function createDecoder(): DecoderInterface;

    public function contentProvider()
    {
        return [
            [[]],
            [[1, 2, 3]],
            [['foo', 'bar']],
            [['foo' => 'bar']],
            [['foo' => ['bar']]],
        ];
    }

    /**
     * @dataProvider contentProvider
     */
    public function testContent(array $content)
    {
        $decoder = $this->createDecoder();

        $this->assertEquals(
            $content,
            $decoder->decode(
                $decoder->encode($content)
            )
        );
    }

    public function testDecodeEmptyString()
    {
        $this->assertSame(
            [],
            $this->createDecoder()->decode('')
        );
    }
}
