<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Interfaces\ObjectInterface;

class ImageFormat implements ObjectInterface
{
    use \OpenRTB\Common\HasData;

    /**
     * @var array<string, string|int|array<string>>
     */
    protected static array $schema = [
        'h' => 'int',
        'w' => 'int',
        'hmin' => 'int',
        'wmin' => 'int',
        'type' => 'int',
        'mimes' => ['string'],
    ];

    /**
     * @return array<string, string|int|array<string>>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setH(int $h): static
    {
        return $this->set('h', $h);
    }

    public function setW(int $w): static
    {
        return $this->set('w', $w);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setHmin(int $hmin): static
    {
        return $this->set('hmin', $hmin);
    }

    public function getHmin(): ?int
    {
        return $this->get('hmin');
    }

    public function setWmin(int $wmin): static
    {
        return $this->set('wmin', $wmin);
    }

    public function getWmin(): ?int
    {
        return $this->get('wmin');
    }

    public function setType(int $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?int
    {
        return $this->get('type');
    }

    /** @param list<string> $mimes */
    public function setMimes(array $mimes): static
    {
        return $this->set('mimes', $mimes);
    }

    /** @return list<string>|null */
    public function getMimes(): ?array
    {
        return $this->get('mimes');
    }
}
