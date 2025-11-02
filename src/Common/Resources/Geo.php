<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Geo implements ObjectInterface
{
    use HasData;

    /**
     * @return array<string, string|class-string|int|float>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'lat' => 'float',
            'lon' => 'float',
            'country' => 'string',
            'region' => 'string',
            'city' => 'string',
            'zip' => 'string',
            'utcoffset' => 'int',
        ];
    }

    public static function getSchema(): array
    {
        return static::getBaseSchema();
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
}
