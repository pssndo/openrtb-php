<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Enums\Placement\ApiFramework;

class VideoAd extends BaseObject
{
    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [
        'apis' => [ApiFramework::class],
        'type' => CreativeType::class,
    ];

    /** @param list<string> $mime */
    public function setMime(array $mime): static
    {
        return $this->set('mime', $mime);
    }

    /** @return list<string>|null */
    public function getMime(): ?array
    {
        return $this->get('mime');
    }

    /** @param list<ApiFramework> $apis */
    public function setApis(array $apis): static
    {
        return $this->set('apis', $apis);
    }

    /** @return list<ApiFramework>|null */
    public function getApis(): ?array
    {
        return $this->get('apis');
    }

    public function setType(CreativeType $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?CreativeType
    {
        return $this->get('type');
    }

    public function setAdm(string $adm): static
    {
        return $this->set('adm', $adm);
    }

    public function getAdm(): ?string
    {
        return $this->get('adm');
    }

    public function setCurl(string $curl): static
    {
        return $this->set('curl', $curl);
    }

    public function getCurl(): ?string
    {
        return $this->get('curl');
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

    public function setDur(int $dur): static
    {
        return $this->set('dur', $dur);
    }

    public function getDur(): ?int
    {
        return $this->get('dur');
    }
}
