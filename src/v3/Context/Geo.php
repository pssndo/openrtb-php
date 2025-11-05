<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\Resources\Geo as CommonGeo;
use OpenRTB\v3\Enums\Context\IpLocationService;
use OpenRTB\v3\Enums\Context\LocationType;

class Geo extends CommonGeo
{
    /**
     * @return array<string, class-string|string|int>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'type' => LocationType::class,
            'ipservice' => IpLocationService::class,
            'accuracy' => 'int',
            'lastfix' => 'int',
            'regionfips104' => 'string',
            'metro' => 'string',
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(parent::getSchema(), static::getBaseSchema());
    }

    public function setType(LocationType $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?LocationType
    {
        return $this->get('type');
    }

    public function setAccuracy(int $accuracy): static
    {
        return $this->set('accuracy', $accuracy);
    }

    public function getAccuracy(): ?int
    {
        return $this->get('accuracy');
    }

    public function setLastfix(int $lastfix): static
    {
        return $this->set('lastfix', $lastfix);
    }

    public function getLastfix(): ?int
    {
        return $this->get('lastfix');
    }

    public function setIpservice(IpLocationService $ipservice): static
    {
        return $this->set('ipservice', $ipservice);
    }

    public function getIpservice(): ?IpLocationService
    {
        return $this->get('ipservice');
    }

    public function setRegionfips104(string $regionfips104): static
    {
        return $this->set('regionfips104', $regionfips104);
    }

    public function getRegionfips104(): ?string
    {
        return $this->get('regionfips104');
    }

    public function setMetro(string $metro): static
    {
        return $this->set('metro', $metro);
    }

    public function getMetro(): ?string
    {
        return $this->get('metro');
    }
}
