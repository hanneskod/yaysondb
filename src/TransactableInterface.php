<?php

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Expression\ExpressionInterface;

/**
 * Defines an entity that supports transactions
 */
interface TransactableInterface
{
    /**
     * Commit changes to persistent storage
     */
    public function commit();

    /**
     * Check if there are non-commited changes
     */
    public function inTransaction(): bool;

    /**
     * Reload content from source
     *
     * This method also works to rollback un-commited changes
     */
    public function reset();
}
