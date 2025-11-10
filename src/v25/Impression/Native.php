<?php

declare(strict_types=1);

namespace OpenRTB\v25\Impression;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf#page=28
 */
class Native implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|class-string|array<string>>
     */
    protected static array $schema = [
        'ext' => Ext::class,
        'request' => 'string',
        'ver' => 'string',
        'api' => ['int'],
        'battr' => ['int'],
    ];

    /**
     * @return array<string, string|class-string|array<string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setRequest(string $request): static
    {
        return $this->set('request', $request);
    }

    public function getRequest(): ?string
    {
        return $this->get('request');
    }

    public function setVer(string $ver): static
    {
        return $this->set('ver', $ver);
    }

    public function getVer(): ?string
    {
        return $this->get('ver');
    }

    /** @param Collection<int>|array<int> $api */
    public function setApi(Collection|array $api): static
    {
        return $this->set('api', $api);
    }

    /** @return list<int>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    /** @param Collection<int>|array<int> $battr */
    public function setBattr(Collection|array $battr): static
    {
        return $this->set('battr', $battr);
    }

    /** @return list<int>|null */
    public function getBattr(): ?array
    {
        return $this->get('battr');
    }

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }
}
