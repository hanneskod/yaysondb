<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Expression\ExpressionInterface;

/**
 * Collection of query operators
 */
class Operators
{
    public static function doc(array $query)
    {
        return new Expression\Doc($query);
    }

    public static function not(ExpressionInterface $expr)
    {
        return new Expression\Not($expr);
    }

    public static function exists()
    {
        return new Expression\Exists();
    }

    public static function type($type)
    {
        return new Expression\Type($type);
    }

    public static function in(array $list)
    {
        return new Expression\In($list);
    }

    public static function regexp($regexp)
    {
        return new Expression\Regexp($regexp);
    }

    public static function equals($operand)
    {
        return new Expression\Comparator\Equals($operand);
    }

    public static function same($operand)
    {
        return new Expression\Comparator\Same($operand);
    }

    public static function greaterThan($operand)
    {
        return new Expression\Comparator\GreaterThan($operand);
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

    public static function all(ExpressionInterface ...$exprs)
    {
        return new Expression\Counter\All(...$exprs);
    }

    public static function atLeastOne(ExpressionInterface ...$exprs)
    {
        return new Expression\Counter\AtLeastOne(...$exprs);
    }

    public static function exactly($count, ExpressionInterface ...$exprs)
    {
        return new Expression\Counter\Exactly($count, ...$exprs);
    }

    public static function none(ExpressionInterface ...$exprs)
    {
        return self::not(self::atLeastOne(...$exprs));
    }

    public static function one(ExpressionInterface ...$exprs)
    {
        return self::exactly(1, ...$exprs);
    }

    public static function listAll(ExpressionInterface $expr)
    {
        return new Expression\Set\ListAll($expr);
    }

    public static function listAtLeastOne(ExpressionInterface $expr)
    {
        return new Expression\Set\ListAtLeastOne($expr);
    }

    public static function listExactly($count, ExpressionInterface $expr)
    {
        return new Expression\Set\ListExactly($count, $expr);
    }

    public static function listNone(ExpressionInterface $expr)
    {
        return self::not(self::listAtLeastOne($expr));
    }

    public static function listOne(ExpressionInterface $expr)
    {
        return self::listExactly(1, $expr);
    }
}
