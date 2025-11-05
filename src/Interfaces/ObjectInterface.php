<?php

declare(strict_types=1);

namespace OpenRTB\Interfaces;

interface ObjectInterface
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;

    public function toJson(int $flags = JSON_UNESCAPED_SLASHES): string|false;

    /**
     * @return array<string, class-string|array<class-string>|string|int|array<string>|array<int>|float>
     */
    public static function getSchema(): array;

    public function set(string $key, mixed $value): static;
}
