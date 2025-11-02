<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Common\Collection;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\EventType;

class EventSpec implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|array<string>>
     */
    protected static array $schema = [
        'type' => EventType::class,
        'method' => ['int'],
    ];

    /**
     * @return array<string, class-string|array<string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setType(EventType $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?EventType
    {
        return $this->get('type');
    }

    /** @param list<int> $method */
    public function setMethod(Collection|array $method): static
    {
        return $this->set('method', is_array($method) ? $method : $method->toArray());
    }

    /** @return Collection<int>|null */
    public function getMethod(): ?Collection
    {
        return new Collection($this->get('method') ?? [], 'int');
    }
}
