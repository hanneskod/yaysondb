<?php

namespace hanneskod\jsondb\Matcher;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait Unary
{
    protected $expected;

    public function __construct($expected)
    {
        $this->expected = $expected;
    }
}
