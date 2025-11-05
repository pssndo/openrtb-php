<?php

declare(strict_types=1);

namespace OpenRTB\Common;

use OpenRTB\Interfaces\ObjectInterface;

trait HasData
{
    protected object $data;

    /** @param array<string, mixed> $data */
    public function __construct(array $data = [])
    {
        if (empty($data)) {
            $this->data = new \stdClass();
        } else {
            $this->data = (object) $data;
        }
    }

    public function set(string $key, mixed $value): static
    {
        $this->data->$key = $value;

        return $this;
    }

    public function get(string $key): mixed
    {
        return $this->data->$key ?? null;
    }

    public function toJson(int $flags = JSON_UNESCAPED_SLASHES): string|false
    {
        return json_encode($this->toArray(), JSON_THROW_ON_ERROR | $flags);
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $convertItem = fn ($item) => match (true) {
            $item instanceof ObjectInterface => $item->toArray(),
            $item instanceof \BackedEnum => $item->value,
            default => $item,
        };

        $result = [];
        // @phpstan-ignore-next-line - foreach on object is valid PHP
        foreach ($this->data as $key => $value) {
            $result[$key] = match (true) {
                $value instanceof ObjectInterface => $value->toArray(),
                $value instanceof Collection => array_map($convertItem, $value->toArray()),
                is_array($value) => array_map($convertItem, $value),
                $value instanceof \BackedEnum => $value->value,
                default => $value,
            };
        }

        return $result;
    }
}
