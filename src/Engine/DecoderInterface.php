<?php

namespace hanneskod\yaysondb\Engine;

/**
 * Defines methods for encoding and decoding content
 */
interface DecoderInterface
{
    /**
     * Encode content into format native to engine
     */
    public function encode(array $docs): string;

    /**
     * Decode native format to content
     */
    public function decode(string $source): array;
}
