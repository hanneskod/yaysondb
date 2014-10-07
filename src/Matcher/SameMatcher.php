<?php

namespace hanneskod\jsondb\Matcher;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class SameMatcher implements Matcher
{
    use Unary;

    public function isMatch($value)
    {
        return $value === $this->expected;
    }
}
