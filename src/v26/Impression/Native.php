<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=28
 */
class Native implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'ext' => Ext::class,
    ];

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

    /** @param list<int> $api */
    public function setApi(array $api): static
    {
        return $this->set('api', $api);
    }

    /** @return list<int>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    /** @param list<int> $battr */
    public function setBattr(array $battr): static
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
