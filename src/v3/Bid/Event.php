<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Bid\EventType;

class Event implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'type' => EventType::class,
        'method' => 'int',
        'url' => 'string',
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setType(EventType $type): self
    {
        return $this->set('type', $type);
    }

    public function setMethod(int $method): self
    {
        return $this->set('method', $method);
    }

    public function setUrl(string $url): self
    {
        return $this->set('url', $url);
    }
}
