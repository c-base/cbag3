<?php

declare(strict_types=1);

namespace Cbase\Shared\Domain;

use Cbase\ArtefactGuide\Domain\Artefact;

/**
 * @template T
 */
abstract class Collection extends \ArrayObject implements \JsonSerializable
{
    final protected function __construct()
    {
        parent::__construct();
    }

    abstract protected function getType(): string;

    /**
     * @param array<T> $items
     */
    public static function create(array $items = []): static
    {
        $collection = new static();
        foreach ($items as $item) {
            $collection->append($item);
        }
        return $collection;
    }

    /**
     * @param T $item
     */
    public function append($item): void
    {
        $type = $this->getType();
        if (!$item instanceof $type) {
            throw new \InvalidArgumentException('$item is not of type ' . $this->getType());
        }
        parent::append($item);
    }

    public function jsonSerialize(): array
    {
        return $this->getArrayCopy();
    }
}
