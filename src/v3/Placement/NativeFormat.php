<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\Collection;
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

    /** @param Collection<AssetFormat>|array<AssetFormat> $asset */
    public function setAsset(Collection|array $asset): static
    {
        return $this->set('asset', is_array($asset) ? $asset : $asset->toArray());
    }

    /** @return Collection<AssetFormat>|null */
    public function getAsset(): ?Collection
    {
        return new Collection($this->get('asset') ?? [], AssetFormat::class);
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
