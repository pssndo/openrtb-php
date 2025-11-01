<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class NativeFormat implements ObjectInterface
{
    use HasData;

    /** @var array<string, array<class-string>> */
    protected static array $schema = [
        'asset' => [AssetFormat::class],
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    /** @param list<AssetFormat> $asset */
    public function setAsset(array $asset): static
    {
        return $this->set('asset', $asset);
    }

    /** @return list<AssetFormat>|null */
    public function getAsset(): ?array
    {
        return $this->get('asset');
    }

    public function setPriv(int $priv): static
    {
        return $this->set('priv', $priv);
    }

    public function getPriv(): ?int
    {
        return $this->get('priv');
    }
}
