<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;

class NativeAd extends BaseObject
{
    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [
        'asset' => [Asset::class],
        'link' => Link::class,
    ];

    /** @param list<Asset> $asset */
    public function setAsset(array $asset): static
    {
        return $this->set('asset', $asset);
    }

    /** @return list<Asset>|null */
    public function getAsset(): ?array
    {
        return $this->get('asset');
    }

    public function setLink(Link $link): static
    {
        return $this->set('link', $link);
    }

    public function getLink(): ?Link
    {
        return $this->get('link');
    }

    public function setJstracker(string $jstracker): static
    {
        return $this->set('jstracker', $jstracker);
    }

    public function getJstracker(): ?string
    {
        return $this->get('jstracker');
    }

    /** @param list<string> $imptrackers */
    public function setImptrackers(array $imptrackers): static
    {
        return $this->set('imptrackers', $imptrackers);
    }

    /** @return list<string>|null */
    public function getImptrackers(): ?array
    {
        return $this->get('imptrackers');
    }

    public function setVer(string $ver): static
    {
        return $this->set('ver', $ver);
    }

    public function getVer(): ?string
    {
        return $this->get('ver');
    }
}
