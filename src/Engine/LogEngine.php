<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb\Engine;

use hanneskod\yaysondb\Exception\LogicException;

/**
 * Simple engine for logging purposes
 */
class LogEngine implements EngineInterface
{
    /**
     * @var string
     */
    private $fname;

    /**
     * @var resource Log stream
     */
    private $stream;

    /**
     * @var DecoderInterface Decoder used to encode and deconde content
     */
    private $decoder;

    /**
     * @var array List of non-commited documents
     */
    private $newDocs = [];

    public function __construct(string $fname, DecoderInterface $decoder = null)
    {
        $this->fname = $fname;
        $this->stream = fopen($fname, 'a+');
        $this->decoder = $decoder ?: new SerializingDecoder;
    }

    public function getId(): string
    {
        return $this->fname;
    }

    public function getIterator(): \Generator
    {
        rewind($this->stream);

        while ($line = fgets($this->stream)) {
            yield $this->decoder->decode($line);
        }
    }

    /**
     * @throws LogicException If id is specified
     */
    public function write(string $id, array $doc): string
    {
        if ($id) {
            throw new LogicException('Specifying a document id at write is not supported by LogEngine');
        }

        $this->newDocs[] = $doc;
        return '';
    }

    public function inTransaction(): bool
    {
        return !empty($this->newDocs);
    }

    public function reset()
    {
        $this->newDocs = [];
    }

    public function commit()
    {
        foreach ($this->newDocs as $doc) {
            fwrite(
                $this->stream,
                $this->decoder->encode($doc) . PHP_EOL
            );
        }

        $this->reset();
    }

    /**
     * @throws LogicException Not supported by LogEngine
     */
    public function has(string $id): bool
    {
        throw new LogicException('has() is not supported by LogEngine');
    }

    /**
     * @throws LogicException Not supported by LogEngine
     */
    public function read(string $id): array
    {
        throw new LogicException('read() is not supported by LogEngine');
    }

    /**
     * @throws LogicException Not supported by LogEngine
     */
    public function delete(string $id): bool
    {
        throw new LogicException('delete() is not supported by LogEngine');
    }

    /**
     * @throws LogicException Not supported by LogEngine
     */
    public function clear()
    {
        throw new LogicException('clear() is not supported by LogEngine');
    }
}
