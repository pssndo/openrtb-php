<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid\Display;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Bid\Link;

class Native implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'link' => Link::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setLink(Link $link): self
    {
        return $this->set('link', $link);
    }

    public function getLink(): ?Link
    {
        return $this->get('link');
    }

    /** @param list<string> $asset */
    public function setAsset(array $asset): self
    {
        return $this->set('asset', $asset);
    }

    /** @return list<string>|null */
    public function getAsset(): ?array
    {
        return $this->get('asset');
    }
}
