<?php

namespace hanneskod\jsondb\Matcher;

/**
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class ConditionsMatcher implements Matcher
{
    private $matchers = [];

    public function __construct(array $conditions)
    {
        // TODO what about more complex nested conditions..

        /** @var Expr $expr */
        foreach ($conditions as $key => $expr) {
            $this->matchers[] = function(\StdClass $record) use ($key, $expr) {
                // TODO what if $record[$key] is not definied??
                return $expr->isMatch($record->$key);
            };
        }
    }

    public function isMatch($record)
    {
        foreach ($this->matchers as $matcher) {
            if (!$matcher($record)) {
                return false;
            }
        }
        return true;
    }
}
