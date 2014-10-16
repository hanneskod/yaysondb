<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb\Expr;

/**
 * Check if $operand matches regular expression
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class Regexp implements \hanneskod\yaysondb\Expr
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
    public function __construct($regexp)
    {
        $this->regexp = $regexp;
    }

    /**
     * Check if $operand matches regular expression
     *
     * @param  mixed $operand
     * @return bool
     */
    public function evaluate($operand)
    {
        return !!preg_match($this->regexp, $operand);
    }
}
