<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Source implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'tid' => 'string',
        'ts' => 'int',
        'ds' => 'string',
        'dsmap' => 'string',
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setTid(string $tid): self
    {
        return $this->set('tid', $tid);
    }

    public function getTid(): ?string
    {
        return $this->get('tid');
    }

    public function setTs(int $ts): self
    {
        return $this->set('ts', $ts);
    }

    public function getTs(): ?int
    {
        return $this->get('ts');
    }

    public function setDs(string $ds): self
    {
        return $this->set('ds', $ds);
    }

    public function getDs(): ?string
    {
        return $this->get('ds');
    }

    public function setDsmap(string $dsmap): self
    {
        return $this->set('dsmap', $dsmap);
    }

    public function getDsmap(): ?string
    {
        return $this->get('dsmap');
    }
}
