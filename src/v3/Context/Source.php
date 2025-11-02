<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\Resources\Source as CommonSource;

class Source extends CommonSource
{
    /**
     * @return array<string, string|int>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'ts' => 'int',
            'ds' => 'string',
            'dsmap' => 'string',
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonSource::getBaseSchema(), static::getBaseSchema());
    }

    public function setTs(int $ts): static
    {
        return $this->set('ts', $ts);
    }

    public function getTs(): ?int
    {
        return $this->get('ts');
    }

    public function setDs(string $ds): static
    {
        return $this->set('ds', $ds);
    }

    public function getDs(): ?string
    {
        return $this->get('ds');
    }

    public function setDsmap(string $dsmap): static
    {
        return $this->set('dsmap', $dsmap);
    }

    public function getDsmap(): ?string
    {
        return $this->get('dsmap');
    }
}
