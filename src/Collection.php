<?php

declare(strict_types = 1);

namespace hanneskod\yaysondb;

use hanneskod\yaysondb\Engine\EngineInterface;
use hanneskod\yaysondb\Expression\ExpressionInterface;

/**
 * Access class for a collection of documents
 */
class Collection extends Filterable implements CollectionInterface
{
    /**
     * @var EngineInterface
     */
    private $engine;

    public function __construct(EngineInterface $engine)
    {
        parent::__construct($engine);
        $this->engine = $engine;
    }

    public function has(string $id): bool
    {
        return $this->engine->has($id);
    }

    public function read(string $id): array
    {
        if (!$this->has($id)) {
            throw new Exception\LogicException("Document $id does not exist, did you call has()?");
        }

        return $this->engine->read($id);
    }

    public function insert(array $document): string
    {
        return $this->engine->write('', $document);
    }

    public function update(ExpressionInterface $expression, array $newDocument): int
    {
        $count = 0;

        foreach ($this->find($expression) as $id => $oldDocument) {
            $this->engine->write((string)$id, array_replace_recursive($oldDocument, $newDocument));
            $count++;
        }

        return $count;
    }

    public function delete(ExpressionInterface $expression): int
    {
        $count = 0;

        foreach ($this->find($expression) as $id => $document) {
            if ($this->engine->delete((string)$id)) {
                $count++;
            }
        }

        return $count;
    }

    public function commit()
    {
        return $this->engine->commit();
    }

    public function inTransaction(): bool
    {
        return $this->engine->inTransaction();
    }

    public function reset()
    {
        return $this->engine->reset();
    }
}
