<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Filter;

use hanneskod\yaysondb\Expression\ExpressionInterface;

/**
 * Filter documents matching search expression
 */
class ExpressionFilter implements FilterInterface
{
    /**
     * @var ExpressionInterface Search expression
     */
    private $expression;

    /**
     * Set search expression
     */
    public function __construct(ExpressionInterface $expression)
    {
        $this->expression = $expression;
    }

    public function filter(\Traversable $documents): \Generator
    {
        foreach ($documents as $id => $doc) {
            if ($this->expression->evaluate($doc)) {
                yield $id => $doc;
            }
        }
    }
}
