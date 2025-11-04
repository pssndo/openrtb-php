<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\Placement\ApiFramework;
use OpenRTB\Common\Collection;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-3.0-Framework-FINAL.pdf#page=59
 */
class Video implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|array<class-string>|int>
     */
    protected static array $schema = [
        'adm' => 'string',
        'curl' => 'string',
        'api' => [ApiFramework::class],
        'ctype' => 'string',
        'mime' => 'string',
        'dur' => 'int',
        'w' => 'int',
        'h' => 'int',
        'wratio' => 'int',
        'hratio' => 'int',
        'priv' => 'string',
        'event' => [Event::class],
    ];

    /**
     * @return array<string, string|array<class-string>|int>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function getAdm(): ?string
    {
        return $this->get('adm');
    }

    public function setAdm(string $adm): static
    {
        return $this->set('adm', $adm);
    }

    public function getCurl(): ?string
    {
        return $this->get('curl');
    }

    public function setCurl(string $curl): static
    {
        return $this->set('curl', $curl);
    }

    /** @return list<ApiFramework>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    /** @param Collection<ApiFramework>|array<ApiFramework> $api */
    public function setApi(Collection|array $api): static
    {
        return $this->set('api', $api);
    }

    public function getCtype(): ?string
    {
        return $this->get('ctype');
    }

    public function setCtype(string $ctype): static
    {
        return $this->set('ctype', $ctype);
    }

    public function getMime(): ?string
    {
        return $this->get('mime');
    }

    public function setMime(string $mime): static
    {
        return $this->set('mime', $mime);
    }

    public function getDur(): ?int
    {
        return $this->get('dur');
    }

    public function setDur(int $dur): static
    {
        return $this->set('dur', $dur);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setW(int $w): static
    {
        return $this->set('w', $w);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }

    public function setH(int $h): static
    {
        return $this->set('h', $h);
    }

    public function getWratio(): ?int
    {
        return $this->get('wratio');
    }

    public function setWratio(int $wratio): static
    {
        return $this->set('wratio', $wratio);
    }

    public function getHratio(): ?int
    {
        return $this->get('hratio');
    }

    public function setHratio(int $hratio): static
    {
        return $this->set('hratio', $hratio);
    }

    public function getPriv(): ?string
    {
        return $this->get('priv');
    }

    public function setPriv(string $priv): static
    {
        return $this->set('priv', $priv);
    }

    /** @return list<Event>|null */
    public function getEvent(): ?array
    {
        return $this->get('event');
    }

    /** @param Collection<Event>|array<Event> $event */
    public function setEvent(Collection|array $event): static
    {
        return $this->set('event', $event);
    }
}
