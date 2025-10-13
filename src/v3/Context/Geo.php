<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\Context\IpLocationService;
use OpenRTB\v3\Enums\Context\LocationType;

class Geo extends BaseObject
{
    protected static array $schema = [
        'type' => LocationType::class,
        'ipservice' => IpLocationService::class,
    ];

    public function setLat(float $lat): self
    {
        return $this->set('lat', $lat);
    }

    public function getLat(): ?float
    {
        return $this->get('lat');
    }

    public function setLon(float $lon): self
    {
        return $this->set('lon', $lon);
    }

    public function getLon(): ?float
    {
        return $this->get('lon');
    }

    public function setType(LocationType $type): self
    {
        return $this->set('type', $type);
    }

    public function getType(): ?LocationType
    {
        return $this->get('type');
    }

    public function setAccuracy(int $accuracy): self
    {
        return $this->set('accuracy', $accuracy);
    }

    public function getAccuracy(): ?int
    {
        return $this->get('accuracy');
    }

    public function setLastfix(int $lastfix): self
    {
        return $this->set('lastfix', $lastfix);
    }

    public function getLastfix(): ?int
    {
        return $this->get('lastfix');
    }

    public function setIpservice(IpLocationService $ipservice): self
    {
        return $this->set('ipservice', $ipservice);
    }

    public function getIpservice(): ?IpLocationService
    {
        return $this->get('ipservice');
    }

    public function setCountry(string $country): self
    {
        return $this->set('country', $country);
    }

    public function getCountry(): ?string
    {
        return $this->get('country');
    }

    public function setRegion(string $region): self
    {
        return $this->set('region', $region);
    }

    public function getRegion(): ?string
    {
        return $this->get('region');
    }

    public function setRegionfips104(string $regionfips104): self
    {
        return $this->set('regionfips104', $regionfips104);
    }

    public function getRegionfips104(): ?string
    {
        return $this->get('regionfips104');
    }

    public function setMetro(string $metro): self
    {
        return $this->set('metro', $metro);
    }

    public function getMetro(): ?string
    {
        return $this->get('metro');
    }

    public function setCity(string $city): self
    {
        return $this->set('city', $city);
    }

    public function getCity(): ?string
    {
        return $this->get('city');
    }

    public function setZip(string $zip): self
    {
        return $this->set('zip', $zip);
    }

    public function getZip(): ?string
    {
        return $this->get('zip');
    }

    public function setUtcoffset(int $utcoffset): self
    {
        return $this->set('utcoffset', $utcoffset);
    }

    public function getUtcoffset(): ?int
    {
        return $this->get('utcoffset');
    }
}
