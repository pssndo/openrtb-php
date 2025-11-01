<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Placement\EventType;

class EventSpec implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'type' => EventType::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setType(EventType $type): self
    {
        return $this->set('type', $type);
    }

    public function getType(): ?EventType
    {
        return $this->get('type');
    }

    public function setMethod(array $method): self
    {
        return $this->set('method', $method);
    }

    public function getMethod(): ?array
    {
        return $this->get('method');
    }
}
