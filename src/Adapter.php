<?php

namespace hanneskod\yaysondb;

/**
 * IO adapter
 */
interface Adapter
{
    /**
     * Read resource
     *
     * @param  string $id
     * @return string
     * @throws Exception\AdapterException If resource is not found
     */
    public function read($id);

    /**
     * Write resource
     *
     * @param  string $id
     * @param  string $contents
     * @return null
     */
    public function write($id, $contents);
}
