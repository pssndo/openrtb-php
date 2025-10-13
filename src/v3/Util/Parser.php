<?php

declare(strict_types=1);

namespace OpenRTB\v3\Util;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Request;
use OpenRTB\v3\Response;

class Parser
{
    public static function parseRequest(string $json): ?Request
    {
        /** @var Request|null $request */
        $request = self::parse($json, Request::class);
        return $request;
    }

    public static function parseResponse(string $json): ?Response
    {
        /** @var Response|null $response */
        $response = self::parse($json, Response::class);
        return $response;
    }

    /**
     * @template T of BaseObject
     * @param class-string<T> $class
     * @return T|null
     */
    public static function parse(string $json, string $class): ?BaseObject
    {
        $data = json_decode($json, true);
        return ($data === null) ? null : self::hydrate($class, $data);
    }

    /**
     * @template T of BaseObject
     * @param class-string<T> $class
     * @param array<string, mixed> $data
     * @return T
     */
    private static function hydrate(string $class, array $data): BaseObject
    {
        $schema = $class::getSchema();
        $hydratedData = [];

        foreach ($data as $key => $value) {
            if (!isset($schema[$key])) {
                $hydratedData[$key] = $value;
                continue;
            }

            $hydratedData[$key] = self::hydrateValue($schema[$key], $value);
        }

        return new $class($hydratedData);
    }

    /**
     * @param class-string|array<class-string> $type
     * @param mixed $value
     * @return mixed
     */
    private static function hydrateValue(string|array $type, mixed $value): mixed
    {
        if (is_string($type)) {
            if (enum_exists($type) && is_subclass_of($type, \BackedEnum::class)) {
                return $type::from($value);
            }

            if (is_subclass_of($type, BaseObject::class)) {
                return self::hydrate($type, $value);
            }
        }

        if (is_array($type) && isset($type[0])) {
            $itemClass = $type[0];
            if (enum_exists($itemClass) && is_subclass_of($itemClass, \BackedEnum::class)) {
                return array_map(static fn ($v) => $itemClass::from($v), $value);
            }

            if (is_subclass_of($itemClass, BaseObject::class)) {
                return array_map(static fn ($v) => self::hydrate($itemClass, $v), $value);
            }
        }

        return $value;
    }
}
