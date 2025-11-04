<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Bid\Display\Banner;
use OpenRTB\v3\Bid\Display\Native;
use OpenRTB\v3\Enums\Placement\ApiFramework;

class Display implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|array<class-string>|string>
     */
    protected static array $schema = [
        'banner' => Banner::class,
        'native' => Native::class,
        'mime' => 'string',
        'api' => [ApiFramework::class],
        'ctype' => 'int',
        'w' => 'int',
        'h' => 'int',
        'wratio' => 'int',
        'hratio' => 'int',
        'priv' => 'string',
        'adm' => 'string',
        'curl' => 'string',
        'event' => [Event::class],
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setBanner(Banner $banner): static
    {
        return $this->set('banner', $banner);
    }

    public function getBanner(): ?Banner
    {
        return $this->get('banner');
    }

    public function setNative(Native $native): static
    {
        return $this->set('native', $native);
    }

    public function getNative(): ?Native
    {
        return $this->get('native');
    }

    public function setMime(string $mime): static
    {
        return $this->set('mime', $mime);
    }

    public function getMime(): ?string
    {
        return $this->get('mime');
    }

    /** @param array<ApiFramework> $api */
    public function setApi(array $api): static
    {
        return $this->set('api', $api);
    }

    /** @return list<ApiFramework>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    public function setCtype(int $ctype): static
    {
        return $this->set('ctype', $ctype);
    }

    public function getCtype(): ?int
    {
        return $this->get('ctype');
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

    public function setPriv(string $priv): static
    {
        return $this->set('priv', $priv);
    }

    public function getPriv(): ?string
    {
        return $this->get('priv');
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

    /** @param array<Event> $event */
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
