<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

use hanneskod\yaysondb\Exception\FileNotFoundException;
use hanneskod\yaysondb\Exception\FileModifiedException;
use hanneskod\yaysondb\Exception\FileNotReadableException;
use hanneskod\yaysondb\Exception\FileNotWritableException;
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
    private $fsystem;

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

    /**
     * @throws FileNotFoundException If fname does not exist in filesystem
     */
    public function __construct(string $fname, FilesystemInterface $fsystem, DecoderInterface $decoder = null)
    {
        if (!$fsystem->has($fname)) {
            throw new FileNotFoundException("Unable to read '$fname'");
        }

        $this->fname = $fname;
        $this->fsystem = $fsystem;
        $this->decoder = $decoder ?: $this->guessDecoder();
        $this->reset();
    }

    public function getId(): string
    {
        return $this->fname;
    }

    public function reset()
    {
        $this->inTransaction = false;
        $raw = $this->fsystem->read($this->fname);

        if (false === $raw) {
            throw new FileNotReadableException("Unable to read '{$this->fname}'");
        }

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
        if (!empty($this->docs)) {
            $this->inTransaction = true;
            $this->docs = [];
        }
    }

    public function inTransaction(): bool
    {
        return $this->inTransaction;
    }

    /**
     * @throws FileModifiedException If source is out of date
     */
    public function commit()
    {
        if (md5($this->fsystem->read($this->fname)) != $this->hash) {
            throw new FileModifiedException("Unable to commit changes, '{$this->fname}' has changed on disk");
        }

        $raw = $this->decoder->encode($this->docs);

        if (!$this->fsystem->update($this->fname, $raw)) {
            throw new FileNotWritableException("Unable to write to '{$this->fname}'");
        }

        $this->hash = md5($raw);
        $this->inTransaction = false;
    }

    /**
     * Create a decoder based of source file mime-type
     */
    private function guessDecoder(): DecoderInterface
    {
        switch ($this->fsystem->getMimetype($this->fname)) {
            case 'application/x-httpd-php':
                return new PhpDecoder;
            case 'text/plain':
            case 'application/json':
            default:
                return new JsonDecoder;
        }
    }
}
