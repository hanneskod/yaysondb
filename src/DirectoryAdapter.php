<?php
/**
 * This program is free software. It comes without any warranty.
 */

namespace hanneskod\yaysondb;

/**
 * IO from specified directory
 *
 * @author Hannes Forsgård <hannes.forsgard@fripost.org>
 */
class DirectoryAdapter implements Adapter
{
    /**
     * @var string The directory to read and write from
     */
    private $dir;

    /**
     * Set name of directory
     *
     * @param string $dir
     */
    public function __construct($dir)
    {
        $this->dir = $dir;
    }

    /**
     * Read resource
     *
     * @param  string $id
     * @return string
     * @throws Exception\AdapterException If resource is not found
     */
    public function read($id)
    {
        $filename = $this->buildFilename($id);
        if (!is_readable($filename)) {
            throw new Exception\AdapterException("Unable to locate collection <$id>");
        }
        return file_get_contents($filename);
    }

    /**
     * Write resource
     *
     * @param  string $id
     * @param  string $contents
     * @return null
     */
    public function write($id, $contents)
    {
        file_put_contents($this->buildFilename($id), $contents);
    }

    /**
     * Create filename for id
     *
     * @param  string $id
     * @return string
     */
    private function buildFilename($id)
    {
        return $this->dir . DIRECTORY_SEPARATOR . $id . '.json';
    }
}
