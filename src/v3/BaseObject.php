<?php

declare(strict_types=1);

namespace OpenRTB\v3;

abstract class BaseObject
{
    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [];

    /** @var array<string, mixed> */
    protected array $data = [];

    /**
     * @param array<string, mixed> $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return array<string, class-string|array<class-string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    /**
     * @param mixed $value
     * @return static
     */
    public function set(string $key, mixed $value): static
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $result = [];
        foreach ($this->data as $key => $value) {
            if ($value instanceof \BackedEnum) {
                $result[$key] = $value->value;
            } elseif ($value instanceof BaseObject) {
                $result[$key] = $value->toArray();
            } elseif (is_array($value)) {
                $result[$key] = array_map(function ($item) {
                    if ($item instanceof \BackedEnum) {
                        return $item->value;
                    }
                    return $item instanceof BaseObject ? $item->toArray() : $item;
                }, $value);
            } else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    public function toJson(int $flags = JSON_UNESCAPED_SLASHES): string|false
    {
        return json_encode($this->toArray(), $flags);
    }
}
