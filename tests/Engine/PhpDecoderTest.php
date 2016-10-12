<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

class PhpDecoderTest extends AbstractsonDecorderTest
{
    protected function createDecoder(): DecoderInterface
    {
        return new PhpDecoder;
    }
}
