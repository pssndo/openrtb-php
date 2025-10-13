<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\CreativeType;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\v3\Placement\Event;

class DisplayAd extends BaseObject
{
    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [
        'apis' => [ApiFramework::class],
        'type' => CreativeType::class,
        'banner' => Banner::class,
        'native' => NativeAd::class,
        'event' => [Event::class],
    ];

    public function setMime(string $mime): static
    {
        return $this->set('mime', $mime);
    }

    public function getMime(): ?string
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

    public function setWratio(int $wratio): static
    {
        return $this->set('wratio', $wratio);
    }

    public function getWratio(): ?int
    {
        return $this->get('wratio');
    }

    public function setHratio(int $hratio): static
    {
        return $this->set('hratio', $hratio);
    }

    public function getHratio(): ?int
    {
        return $this->get('hratio');
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

    public function setBanner(Banner $banner): static
    {
        return $this->set('banner', $banner);
    }

    public function getBanner(): ?Banner
    {
        return $this->get('banner');
    }

    public function setNative(NativeAd $native): static
    {
        return $this->set('native', $native);
    }

    public function getNative(): ?NativeAd
    {
        return $this->get('native');
    }

    /** @param list<Event> $event */
    public function setEvent(array $event): static
    {
        return $this->set('event', $event);
    }

    /** @return list<Event>|null */
    public function getEvent(): ?array
    {
        return $this->get('event');
    }
}
