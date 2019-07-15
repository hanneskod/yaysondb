<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

use hanneskod\yaysondb\Exception\RuntimeException;

class FlatJsonDecoder extends JsonDecoder
{
    public function encode(array $content): string
    {
        $json = json_encode($content);

        if (!$json) {
            throw new RuntimeException("Unable to encode malformed content");
        }

        return $json;
    }
}
