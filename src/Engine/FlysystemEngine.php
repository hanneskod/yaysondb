<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

use hanneskod\yaysondb\Exception\SourceModifiedException;
use League\Flysystem\FilesystemInterface;

/**
 * Engine based on a flysystem
 */
class FlysystemEngine implements EngineInterface
{
    /**
     * @var string Name of source file
     */
    private $fname;

    /**
     * @var FilesystemInterface Filesystem where source is found
     */
    private $fs;

    /**
     * @var DecoderInterface Decoder used to encode and deconde content
     */
    private $decoder;

    /**
     * @var array Loaded documents
     */
    private $docs;

    /**
     * @var string Hash of source at last reset
     */
    private $hash;

    /**
     * @var bool Flag if there are un-commited changes
     */
    private $inTransaction;

    public function __construct(string $fname, FilesystemInterface $fs, DecoderInterface $decoder)
    {
        $this->fname = $fname;
        $this->fs = $fs;
        $this->decoder = $decoder;
        $this->reset();
    }

    public function reset()
    {
        $this->inTransaction = false;
        $raw = $this->fs->read($this->fname);
        $this->hash = md5($raw);
        $this->docs = $this->decoder->decode($raw);
    }

    public function getIterator(): \Generator
    {
        foreach ($this->docs as $id => $doc) {
            yield $id => $doc;
        }
    }

    public function has(string $id): bool
    {
        return isset($this->docs[$id]);
    }

    public function read(string $id): array
    {
        if ($this->has($id)) {
            return (array)$this->docs[$id];
        }

        return [];
    }

    public function write(string $id, array $doc): string
    {
        $this->inTransaction = true;

        if ('' !== $id) {
            $this->docs[$id] = $doc;
            return $id;
        }

        $this->docs[] = $doc;
        end($this->docs);

        return (string)key($this->docs);
    }

    public function delete(string $id): bool
    {
        if ($this->has($id)) {
            $this->inTransaction = true;
            unset($this->docs[$id]);

            return true;
        }

        return false;
    }

    public function clear()
    {
        if ($this->docs) {
            $this->inTransaction = true;
            $this->docs = [];
        }
    }

    public function inTransaction(): bool
    {
        return $this->inTransaction;
    }

    /**
     * @throws SourceModifiedException If source is out of date
     */
    public function commit()
    {
        if (md5($this->fs->read($this->fname)) != $this->hash) {
            throw new SourceModifiedException('Unable to commit changes: source data has changed');
        }

        $raw = $this->decoder->encode($this->docs);
        $this->fs->update($this->fname, $raw);
        $this->hash = md5($raw);
        $this->inTransaction = false;
    }
}
