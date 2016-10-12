<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

/**
 * Decoder using serialize() as backend
 */
class SerializingDecoder implements DecoderInterface
{
    /**
     * Serialize content
     */
    public function encode(array $content): string
    {
        return serialize($content);
    }

    /**
     * Unserialize content
     */
    public function decode(string $source): array
    {
        if ('' == $source) {
            return [];
        }

        return (array)unserialize($source);
    }
}
