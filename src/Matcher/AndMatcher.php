<?php

namespace hanneskod\jsondb\Matcher;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class AndMatcher implements Matcher
{
    use Combinatorial;

    public function isMatch($value)
    {
        return $this->left->isMatch($value) && $this->right->isMatch($value);
    }
}
