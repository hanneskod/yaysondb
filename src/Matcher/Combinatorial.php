<?php

namespace hanneskod\jsondb\Matcher;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
trait Combinatorial
{
    protected $left, $right;

    public function __construct(Matcher $left, Matcher $right)
    {
        $this->left = $left;
        $this->right = $right;
    }
}
