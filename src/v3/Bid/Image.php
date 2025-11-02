<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Image implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|int>
     */
    protected static array $schema = [
        'url' => 'string',
        'w' => 'int',
        'h' => 'int',
    ];

    /**
     * @return array<string, string|int>
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

    public function setW(int $w): static
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setH(int $h): static
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }
}
