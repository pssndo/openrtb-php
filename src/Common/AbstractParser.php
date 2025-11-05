<?php

declare(strict_types=1);

namespace OpenRTB\Common;

use BackedEnum;
use OpenRTB\Interfaces\ObjectInterface;

abstract class AbstractParser
{
    /**
     * Hydrates an object from array data using its schema.
     *
     * @template T of ObjectInterface
     *
     * @param array<string, mixed> $data
     * @param class-string<T>      $class
     *
     * @return T
     */
    protected function hydrate(array $data, string $class): ObjectInterface
    {
        // @phpstan-ignore-next-line - Defensive check for invalid data
        if (array_is_list($data)) {
            return new $class();
        }

        $object = new $class();
        $schema = $class::getSchema();

        foreach ($data as $key => $value) {
            $type = $schema[$key] ?? null;
            $object->set($key, $type ? $this->hydrateValue($value, $type) : $value);
        }

        return $object;
    }

    /**
     * Hydrates a value based on its schema type.
     *
     * @param class-string|string|int|float|array<string|int|class-string> $type
     */
    protected function hydrateValue(mixed $value, string|int|float|array $type): mixed
    {
        if (null === $value) {
            return null;
        }

        return is_array($type)
            ? $this->hydrateCollection($value, $type)
            : $this->hydrateSingleValue($value, $type);
    }

    /**
     * Hydrates a collection of values.
     *
     * @param array<string|int|class-string> $type
     *
     * @return Collection|mixed
     */
    protected function hydrateCollection(mixed $value, array $type): mixed
    {
        if (!is_array($value) || !isset($type[0])) {
            return $value;
        }

        $itemType = $type[0];

        $collection = new Collection([], is_string($itemType) ? $itemType : null);

        foreach ($value as $item) {
            try {
                $hydratedItem = $this->hydrateCollectionItem($item, $itemType);
                $collection->add($hydratedItem);
            } catch (\InvalidArgumentException) {
                $collection->add(null);
            }
        }

        return $collection;
    }

    /**
     * Hydrates a single collection item.
     *
     * @param string|int|class-string $itemType
     */
    protected function hydrateCollectionItem(mixed $item, string|int $itemType): mixed
    {
        if (!is_string($itemType)) {
            return $item;
        }

        if ($this->isBackedEnum($itemType)) {
            /* @var class-string<\BackedEnum> $itemType */
            return $this->hydrateEnum($item, $itemType);
        }

        if ($this->isObjectInterface($itemType) && is_array($item)) {
            /* @var class-string<ObjectInterface> $itemType */
            return $this->hydrate($item, $itemType);
        }

        return $item;
    }

    /**
     * Hydrates a single value (object, enum, or scalar).
     *
     * @param class-string|string|int|float $type
     */
    protected function hydrateSingleValue(mixed $value, string|int|float $type): mixed
    {
        if (!is_string($type)) {
            return $value;
        }

        if ($this->isObjectInterface($type)) {
            /* @var class-string<ObjectInterface> $type */
            return $this->hydrateObject($value, $type);
        }

        if ($this->isBackedEnum($type)) {
            /* @var class-string<\BackedEnum> $type */
            return $this->hydrateEnum($value, $type);
        }

        return $value;
    }

    /**
     * Hydrates an object from array data.
     *
     * @param class-string<ObjectInterface> $type
     */
    protected function hydrateObject(mixed $value, string $type): mixed
    {
        if (!is_array($value)) {
            return $value;
        }

        if (array_is_list($value)) {
            $value = $value[0] ?? [];
        }

        return $this->hydrate($value, $type);
    }

    /**
     * Hydrates an enum value.
     *
     * @param class-string<\BackedEnum> $type
     *
     * @return \BackedEnum|mixed
     */
    protected function hydrateEnum(mixed $value, string $type): mixed
    {
        try {
            return $type::from($value);
        } catch (\ValueError) {
            return $value;
        }
    }

    /**
     * Checks if a type is a BackedEnum.
     */
    protected function isBackedEnum(string $type): bool
    {
        return is_subclass_of($type, \BackedEnum::class);
    }

    /**
     * Checks if a type is an ObjectInterface.
     */
    protected function isObjectInterface(string $type): bool
    {
        return is_subclass_of($type, ObjectInterface::class);
    }
}
