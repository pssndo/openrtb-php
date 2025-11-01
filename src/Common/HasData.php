<?php

declare(strict_types=1);

namespace OpenRTB\Common;

use OpenRTB\Interfaces\ObjectInterface;

trait HasData
{
    protected array $data = [];

    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function set(string $key, mixed $value): static
    {
        $this->data[$key] = $value;
        return $this;
    }

    public function get(string $key): mixed
    {
        return $this->data[$key] ?? null;
    }

    public function toArray(): array
    {
        $result = [];
        foreach ($this->data as $key => $value) {
            if ($value instanceof ObjectInterface) {
                $arrayValue = $value->toArray();

                if (empty($arrayValue) && property_exists($value, 'data') && empty($value->data)) {
                    $result[$key] = (object) [];
                } else {
                    $result[$key] = $arrayValue;
                }
            } elseif (is_array($value)) {
                $result[$key] = array_map(function ($item) {
                    if ($item instanceof ObjectInterface) {
                        return $item->toArray();
                    }
                    if ($item instanceof \BackedEnum) { // Handles arrays of enums
                        return $item->value;
                    }
                    return $item;
                }, $value);
            } elseif ($value instanceof \BackedEnum) { // Handles single enums
                $result[$key] = $value->value;
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
