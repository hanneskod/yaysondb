<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

/**
 * Collection of query operators
 */
class Operators
{
    public static function doc(array $query)
    {
        return new Expr\Doc($query);
    }

    public static function not(Expr $expr)
    {
        return new Expr\Not($expr);
    }

    public static function exists()
    {
        return new Expr\Exists();
    }

    public static function type($type)
    {
        return new Expr\Type($type);
    }

    public static function in(array $list)
    {
        return new Expr\In($list);
    }

    public static function regexp($regexp)
    {
        return new Expr\Regexp($regexp);
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

    public static function all(Expr ...$exprs)
    {
        return new Expr\Counter\All(...$exprs);
    }

    public static function atLeastOne(Expr ...$exprs)
    {
        return new Expr\Counter\AtLeastOne(...$exprs);
    }

    public static function exactly($count, Expr ...$exprs)
    {
        return new Expr\Counter\Exactly($count, ...$exprs);
    }

    public static function none(Expr ...$exprs)
    {
        return self::not(self::atLeastOne(...$exprs));
    }

    public static function one(Expr ...$exprs)
    {
        return self::exactly(1, ...$exprs);
    }

    public static function listAll(Expr $expr)
    {
        return new Expr\Set\ListAll($expr);
    }

    public static function listAtLeastOne(Expr $expr)
    {
        return new Expr\Set\ListAtLeastOne($expr);
    }

    public static function listExactly($count, Expr $expr)
    {
        return new Expr\Set\ListExactly($count, $expr);
    }

    public static function listNone(Expr $expr)
    {
        return self::not(self::listAtLeastOne($expr));
    }

    public static function listOne(Expr $expr)
    {
        return self::listExactly(1, $expr);
    }
}
