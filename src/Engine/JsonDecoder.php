<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

/**
 * Decoder for the json format
 */
class JsonDecoder implements DecoderInterface
{
    /**
     * Encode content to json
     */
    public function encode(array $content): string
    {
        return json_encode($content, JSON_PRETTY_PRINT);
    }

    /**
     * Decode json content
     */
    public function decode(string $source): array
    {
        return (array)json_decode($source, true);
    }
}
