<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=38
 */
class Geo implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setLat(float $lat): static
    {
        return $this->set('lat', $lat);
    }

    public function getLat(): ?float
    {
        return $this->get('lat');
    }

    public function setLon(float $lon): static
    {
        return $this->set('lon', $lon);
    }

    public function getLon(): ?float
    {
        return $this->get('lon');
    }

    public function setType(int $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?int
    {
        return $this->get('type');
    }

    public function setCountry(string $country): static
    {
        return $this->set('country', $country);
    }

    public function getCountry(): ?string
    {
        return $this->get('country');
    }

    public function setRegion(string $region): static
    {
        return $this->set('region', $region);
    }

    public function getRegion(): ?string
    {
        return $this->get('region');
    }

    public function setCity(string $city): static
    {
        return $this->set('city', $city);
    }

    public function getCity(): ?string
    {
        return $this->get('city');
    }

    public function setZip(string $zip): static
    {
        return $this->set('zip', $zip);
    }

    public function getZip(): ?string
    {
        return $this->get('zip');
    }

    public function setUtcoffset(int $utcoffset): static
    {
        return $this->set('utcoffset', $utcoffset);
    }

    public function getUtcoffset(): ?int
    {
        return $this->get('utcoffset');
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
