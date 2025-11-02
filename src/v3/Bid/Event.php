<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\EventType;

class Event implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|string>
     */
    protected static array $schema = [
        'type' => EventType::class,
        'method' => 'int',
        'url' => 'string',
    ];

    /**
     * @return array<string, class-string|string>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setType(EventType $type): static
    {
        return $this->set('type', $type);
    }

    public function setMethod(int $method): static
    {
        return $this->set('method', $method);
    }

    public function setUrl(string $url): static
    {
        return $this->set('url', $url);
    }
}
