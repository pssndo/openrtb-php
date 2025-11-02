<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Link implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|array<string>>
     */
    protected static array $schema = [
        'url' => 'string',
        'trkr' => 'array',
        'fallback' => 'string',
    ];

    /**
     * @return array<string, string|array<string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setUrl(string $url): static
    {
        return $this->set('url', $url);
    }

    public function getUrl(): ?string
    {
        return $this->get('url');
    }

    /** @param list<string> $trkr */
    public function setTrkr(array $trkr): static
    {
        return $this->set('trkr', $trkr);
    }

    /** @return list<string>|null */
    public function getTrkr(): ?array
    {
        return $this->get('trkr');
    }

    public function setFallback(string $fallback): static
    {
        return $this->set('fallback', $fallback);
    }

    public function getFallback(): ?string
    {
        return $this->get('fallback');
    }
}
