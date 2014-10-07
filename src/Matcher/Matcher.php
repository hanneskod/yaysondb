<?php

namespace hanneskod\jsondb\Matcher;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
interface Matcher
{
    /**
     * Check if value is a match
     *
     * @param  mixed $value
     * @return bool
     */
    public function isMatch($value);
}
