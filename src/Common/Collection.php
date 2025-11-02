<?php

declare(strict_types=1);

namespace OpenRTB\Common;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;
use OpenRTB\Interfaces\ObjectInterface;

/**
 * @template T
 * @implements ArrayAccess<int, T>
 * @implements IteratorAggregate<int, T>
 */
class Collection implements ArrayAccess, Countable, IteratorAggregate
{
    /** @var array<int, T> */
    protected array $items = [];

    /** @var class-string<T>|string|null */
    protected ?string $itemType = null;

    /**
     * @param Collection<T>|array<int, T> $items
     * @param class-string<T>|string|null $itemType
     */
    public function __construct(Collection|array $items = [], ?string $itemType = null)
    {
        $this->itemType = $items instanceof Collection
            ? ($items->itemType ?? $itemType)
            : $itemType;

        foreach ($this->extractItems($items) as $item) {
            try {
                $this->add($item);
            } catch (InvalidArgumentException $e) {
                // During construction, if an item doesn't match the expected type, add null instead.
                $this->items[] = null;
            }
        }
    }

    /**
     * @param Collection<T>|array<int, T> $items
     * @return array<int, T>
     */
    protected function extractItems(Collection|array $items): array
    {
        return $items instanceof self ? $items->items : $items;
    }

    /**
     * @param T $item
     * @return void
     * @throws InvalidArgumentException
     */
    public function add(mixed $item): void
    {
        if ($this->validateItem($item)) {
            $this->items[] = $item;
        }
    }

    /**
     * @param mixed $item
     * @return bool Returns true if the item is valid, false otherwise.
     * @throws InvalidArgumentException
     */
    protected function validateItem(mixed $item): bool
    {
        if ($this->itemType === null || $item === null) {
            return true;
        }

        // If the expected type is a scalar, we can skip instance validation.
        if (!class_exists($this->itemType) || !is_subclass_of($this->itemType, ObjectInterface::class)) {
            return true;
        }

        if (!$item instanceof $this->itemType) {
            throw new InvalidArgumentException(sprintf(
                'Collection expects items of type %s, %s given.',
                $this->itemType,
                $this->getTypeName($item)
            ));
        }

        return true;
    }

    /**
     * @param mixed $value
     * @return string
     */
    protected function getTypeName(mixed $value): string
    {
        return get_debug_type($value);
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @return T|null
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->items[$offset] ?? null;
    }

    /**
     * @param int|null $offset
     * @param T $value
     * @return void
     * @throws InvalidArgumentException
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->validateItem($value);

        if ($offset === null) {
            $this->items[] = $value;
        } else {
            $this->items[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->items[$offset]);
    }

    public function count(): int
    {
        return count($this->items);
    }

    /**
     * @return Traversable<int, T>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }

    /**
     * Get all items without conversion (returns raw objects)
     * @return array<int, T>
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Convert collection to array (converts objects to arrays for serialization)
     * @return array<int, T|array>
     */
    public function toArray(): array
    {
        return array_map(static function ($item) {
            if ($item instanceof ObjectInterface) {
                return $item->toArray();
            }

            return $item;
        }, $this->items);
    }

    /**
     * @return array<int, T>
     */
    public function __debugInfo(): array
    {
        return $this->items;
    }

    /**
     * @return array<int, T>
     */
    public function __serialize(): array
    {
        return [
            'items' => $this->items,
            'itemType' => $this->itemType,
        ];
    }

    /**
     * @param array{items: array<int, T>, itemType: class-string<T>|string|null} $data
     * @return void
     */
    public function __unserialize(array $data): void
    {
        $this->items = $data['items'];
        $this->itemType = $data['itemType'];
    }
}
