<?php

declare(strict_types=1);

namespace OpenRTB\v3\Util;

use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Request;
use OpenRTB\v3\Response;

class Parser
{
    public static function parseRequest(string $json): Request
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $parser = new self();
        /** @var Request $request */
        $request = $parser->hydrate($data, Request::class);
        return $request;
    }

    public static function parseResponse(string $json): Response
    {
        $data = json_decode($json, true, 512, JSON_THROW_ON_ERROR);
        $parser = new self();
        /** @var Response $response */
        $response = $parser->hydrate($data, Response::class);
        return $response;
    }

    /**
     * @template T of ObjectInterface
     * @param array<string, mixed> $data
     * @param class-string<T> $class
     * @return T
     */
    private function hydrate(array $data, string $class): ObjectInterface|array
    {
        $object = new $class();
        $schema = $class::getSchema();

        foreach ($data as $key => $value) {
            if (isset($schema[$key])) {
                $object->set($key, $this->hydrateValue($value, $schema[$key]));
            } else {
                $object->set($key, $value);
            }
        }

        return $object;
    }

    private function hydrateValue(mixed $value, string|array $type): mixed
    {
        if (is_array($type)) { // It's an array of objects
            $class = $type[0];
            return array_map(function ($itemData) use ($class) {
                // If the class is an enum, just create it from the value
                if (is_subclass_of($class, \BackedEnum::class)) {
                    return $class::from($itemData);
                }
                // Otherwise, it's a complex object that needs full hydration
                // but only if the data is actually an array.
                if (is_array($itemData)) {
                    return $this->hydrate($itemData, $class);
                }
                return $itemData;
            }, $value);
        }

        // It's a single object or an enum
        $class = $type;

        if (is_subclass_of($class, \BackedEnum::class) && (is_int($value) || is_string($value))) {
            return $class::from($value);
        }

        // This is the key fix: if the value is not an array, it cannot be hydrated into an object.
        if (!is_array($value)) {
            return $value;
        }

        if (class_exists($class) && is_subclass_of($class, ObjectInterface::class)) {
            return $this->hydrate($value, $class);
        }

        return $value;
    }
}