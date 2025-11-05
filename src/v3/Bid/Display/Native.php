<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid\Display;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Bid\Link;

class Native implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|string>
     */
    protected static array $schema = [
        'link' => Link::class,
        'asset' => 'array',
    ];

    /**
     * @return array<string, class-string|string>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setLink(Link $link): static
    {
        return $this->set('link', $link);
    }

    public function getLink(): ?Link
    {
        return $this->get('link');
    }

    /** @param Collection<string>|array<string> $asset */
    public function setAsset(Collection|array $asset): static
    {
        return $this->set('asset', $asset);
    }

    /** @return list<string>|null */
    public function getAsset(): ?array
    {
        return $this->get('asset');
    }
}
