<?php

namespace hanneskod\jsondb;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Matchers
{
    // TODO add more semantics

    private static $sematics = [
        'is' => '\\hanneskod\\jsondb\\Matcher\\EqualsMatcher',
        'equals' => '\\hanneskod\\jsondb\\Matcher\\EqualsMatcher',
        'same' => '\\hanneskod\\jsondb\\Matcher\\SameMatcher',
        'all' => '\\hanneskod\\jsondb\\Matcher\\AndMatcher',
        'greaterThan' => '\\hanneskod\\jsondb\\Matcher\\GreaterThanMatcher',
    ];

    public static function __callstatic($name, $arguments)
    {
        // TODO what if $sematics[$name] is not defined..
        $classname = self::$sematics[$name];

        // TODO should take all the arguments
        return new $classname($arguments[0]);
    }
}
