<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Expression;

/**
 * Check if $operand matches regular expression
 */
class Regexp implements ExpressionInterface
{
    /**
     * @var string Internal regular expression
     */
    private $regexp;

    /**
     * Set regular expression
     *
     * @param string $regexp
     */
    public function __construct(string $regexp)
    {
        $this->regexp = $regexp;
    }

    /**
     * Check if $operand matches regular expression
     */
    public function evaluate($operand): bool
    {
        return !!preg_match($this->regexp, $operand);
    }
}
