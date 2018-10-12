<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

use hanneskod\yaysondb\Exception\RuntimeException;

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
        $json = json_encode($content, JSON_PRETTY_PRINT);

        if (!$json) {
            throw new RuntimeException("Unable to encode malformed content");
        }

        return $json;
    }

    /**
     * Decode json content
     */
    public function decode(string $source): array
    {
        return (array)json_decode($source, true);
    }
}
