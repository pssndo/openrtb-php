<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class DisplayFormat implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|array<string>>
     */
    protected static array $schema = [
        'w' => 'int',
        'h' => 'int',
        'wratio' => 'int',
        'hratio' => 'int',
        'expdir' => ['int'],
    ];

    /**
     * @return array<string, string|array<string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
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

    /** @param list<int> $expdir */
    public function setExpdir(array $expdir): static
    {
        return $this->set('expdir', $expdir);
    }

    /** @return list<int>|null */
    public function getExpdir(): ?array
    {
        return $this->get('expdir');
    }
}
