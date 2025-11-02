<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Macro implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string>
     */
    protected static array $schema = [
        'key' => 'string',
        'value' => 'string',
    ];

    /**
     * @return array<string, string>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setKey(string $key): static
    {
        return $this->set('key', $key);
    }

    public function setValue(string $value): static
    {
        return $this->set('value', $value);
    }

    public function getKey(): ?string
    {
        return $this->get('key');
    }

    public function getValue(): ?string
    {
        return $this->get('value');
    }
}
