<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\Placement\EventType;

class Event extends BaseObject
{
    protected static array $schema = [
        'type' => EventType::class,
    ];

    public function setType(EventType $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?EventType
    {
        return $this->get('type');
    }

    public function setMethod(int $method): static
    {
        return $this->set('method', $method);
    }

    public function getMethod(): ?int
    {
        return $this->get('method');
    }

    public function setUrl(string $url): static
    {
        return $this->set('url', $url);
    }

    public function getUrl(): ?string
    {
        return $this->get('url');
    }

    /** @param array<string, mixed> $cdata */
    public function setCdata(array $cdata): static
    {
        return $this->set('cdata', $cdata);
    }

    /** @return array<string, mixed>|null */
    public function getCdata(): ?array
    {
        return $this->get('cdata');
    }
}
