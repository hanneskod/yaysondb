<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

class FlatJsonDecoderTest extends AbstractsonDecorderTest
{
    protected function createDecoder(): DecoderInterface
    {
        return new FlatJsonDecoder;
    }
}
