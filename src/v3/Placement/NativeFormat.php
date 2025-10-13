<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\v3\BaseObject;

class NativeFormat extends BaseObject
{
    /** @var array<string, array<class-string>> */
    protected static array $schema = [
        'asset' => [AssetFormat::class],
    ];

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
