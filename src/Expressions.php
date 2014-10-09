<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb;

/**
 * Convenience handles to expressions
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Expressions
{
    public static function __callstatic($op, $args)
    {
        // TODO implementera dessa sista expressions...

        /*
            Matcher\        // Match pattern to value
                In
                Regexp
                Contains
                Type

            Exists

            List\              // eval expression for each iten in list
                ListEach       // all list items match
                ListIncludes   // at least one list item match
                // fler här.. vad ska de heta egentligen??
                // eller ska jag använda samma namn som för counter, men med list framför
                // blir det enkare att memorera kanske???

         */

        switch ($op) {
            case 'in':       //matchar något från en lista
            case 'type':     //kontrollerar php typ
            case 'regexp':   //matchar regexp
            case 'contains': // string search..
            case 'exists':   // empty operator, forserar check av att fält finns..
        }

        throw \Exception("$op not implemented");
    }

    public static function doc(array $query)
    {
        return new Expr\Doc($query);
    }

    public static function not(Expr $expr)
    {
        return new Expr\Not($expr);
    }

    public static function all(Expr ...$exprs)
    {
        return new Expr\Counter\All($expr);
    }

    public static function atLeastOne(Expr ...$exprs)
    {
        return new Expr\Counter\AtLeastOne($exprs);
    }

    public static function exactly($count, Expr ...$exprs)
    {
        return new Expr\Counter\Exactly($count, $exprs);
    }

    public static function none(Expr ...$exprs)
    {
        return self::not(self::atLeastOne($exprs));
    }

    public static function one(Expr ...$exprs)
    {
        return self::exactly(1, $exprs);
    }

    public static function equals($operand)
    {
        return new Expr\Comparator\Equals($operand);
    }

    public static function same($operand)
    {
        return new Expr\Comparator\Same($operand);
    }

    public static function greaterThan($operand)
    {
        return new Expr\Comparator\GreaterThan($operand);
    }

    public static function greaterThanOrEquals($operand)
    {
        return self::atLeastOne(
            self::equals($operand),
            self::greaterThan($operand)
        );
    }

    public static function lessThan($operand)
    {
        return self::not(self::greaterThanOrEquals($operand));
    }

    public static function lessThanOrEquals($operand)
    {
        return self::atLeastOne(
            self::equals($operand),
            self::lessThan($operand)
        );
    }
}
