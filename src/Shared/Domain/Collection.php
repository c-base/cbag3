<?php
/*
 * (c) 2022 dazz <dazz@c-base.org>
 *
 * For copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
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
    public function append(mixed $item): void
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

    public function contains(mixed $element)
    {
        return in_array($element, $this->getArrayCopy(), true);
    }

    public function removeElement(mixed $element)
    {
        $key = array_search($element, $this->getArrayCopy(), true);

        if ($key === false) {
            return false;
        }

        unset($this[$key]);

        return true;
    }
}
