<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Data implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'value' => 'string',
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setValue(string $value): self
    {
        return $this->set('value', $value);
    }

    public function getValue(): ?string
    {
        return $this->get('value');
    }
}
