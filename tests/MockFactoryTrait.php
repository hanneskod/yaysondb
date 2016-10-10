<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Expression\ExpressionInterface;

trait MockFactoryTrait
{
    abstract function createMock($originalClassName);

    protected function createExpressionMock(bool $return)
    {
        $expression = $this->createMock(ExpressionInterface::CLASS);
        $expression->expects($this->any())
            ->method('evaluate')
            ->will($this->returnValue($return));

        return $expression;
    }
}
