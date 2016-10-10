<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

/**
 * Decoder using var_export as backend
 */
class PhpDecoder implements DecoderInterface
{
    /**
     * Encode content into php code
     */
    public function encode(array $content): string
    {
        return 'return ' . var_export($content, true) . ';';
    }

    /**
     * Decode source by calling eval
     */
    public function decode(string $source): array
    {
        return (array)eval($source);
    }
}
