<?php

declare(strict_types=1);

namespace OpenRTB\Common;

use OpenRTB\Interfaces\ObjectInterface;

abstract class AbstractParser
{
    /**
     * @template T of ObjectInterface
     * @param array<string, mixed> $data
     * @param class-string<T> $class
     * @return T
     */
    protected function hydrate(array $data, string $class): ObjectInterface
    {
        $object = new $class();
        $schema = $class::getSchema();

        foreach ($data as $key => $value) {
            if (isset($schema[$key])) {
                $object->set($key, $this->hydrateValue($value, $schema[$key]));
            } else {
                // Pass through unknown properties
                $object->set($key, $value);
            }
        }

        return $object;
    }

    private function hydrateValue(mixed $value, string|array $type): mixed
    {
        if (is_array($type)) { // It's an array of objects or enums
            $class = $type[0];
            return array_map(fn($itemData) => $this->hydrateArrayItem($itemData, $class), $value);
        }

        // It's a single object or an enum
        $class = $type;

        if (is_subclass_of($class, \BackedEnum::class) && (is_int($value) || is_string($value))) {
            return $class::from($value);
        }

        if (is_subclass_of($class, ObjectInterface::class) && is_array($value)) {
            return $this->hydrate($value, $class);
        }

        return $value;
    }

    private function hydrateArrayItem(mixed $itemData, string $class): mixed
    {
        // If the class is an enum, create it from the value
        if (is_subclass_of($class, \BackedEnum::class)) {
            return $class::from($itemData);
        }
        // Otherwise, it's a complex object that needs full hydration
        if (is_array($itemData)) {
            return $this->hydrate($itemData, $class);
        }
        // This line is covered when $type is an array of ObjectInterface and $itemData is not an array.
        // See AbstractParserTest::testHydrateValueWithArrayOfMixedItemsInObjectArray.
        return $itemData;
    }
}
