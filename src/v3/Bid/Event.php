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
     * @var array<string, class-string|string|array<string>>
     */
    protected static array $schema = [
        'type' => EventType::class,
        'method' => 'int',
        'url' => 'string',
        'api' => ['int'],
        'win' => ['string'],
        'furl' => ['string'],
    ];

    /**
     * @return array<string, class-string|string|array<string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function getType(): ?EventType
    {
        return $this->get('type');
    }

    public function setType(EventType $type): static
    {
        return $this->set('type', $type);
    }

    public function getMethod(): ?int
    {
        return $this->get('method');
    }

    public function setMethod(int $method): static
    {
        return $this->set('method', $method);
    }

    public function getUrl(): ?string
    {
        return $this->get('url');
    }

    public function setUrl(string $url): static
    {
        return $this->set('url', $url);
    }

    /** @return list<int>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    /** @param array<int> $api */
    public function setApi(array $api): static
    {
        return $this->set('api', $api);
    }

    /** @return list<string>|null */
    public function getWin(): ?array
    {
        return $this->get('win');
    }

    /** @param array<string> $win */
    public function setWin(array $win): static
    {
        return $this->set('win', $win);
    }

    /** @return list<string>|null */
    public function getFurl(): ?array
    {
        return $this->get('furl');
    }

    /** @param array<string> $furl */
    public function setFurl(array $furl): static
    {
        return $this->set('furl', $furl);
    }
}
