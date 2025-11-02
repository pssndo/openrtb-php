<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Interfaces\ObjectInterface;

class ImageFormat implements ObjectInterface
{
    use \OpenRTB\Common\HasData;

    protected static array $schema = [];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setH(int $h): self
    {
        return $this->set('h', $h);
    }

    public function setW(int $w): self
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

    public function setHmin(int $hmin): self
    {
        return $this->set('hmin', $hmin);
    }

    public function getHmin(): ?int
    {
        return $this->get('hmin');
    }

    public function setWmin(int $wmin): self
    {
        return $this->set('wmin', $wmin);
    }

    public function getWmin(): ?int
    {
        return $this->get('wmin');
    }

    public function setType(int $type): self
    {
        return $this->set('type', $type);
    }

    public function getType(): ?int
    {
        return $this->get('type');
    }

    public function setMimes(array $mimes): self
    {
        return $this->set('mimes', $mimes);
    }

    public function getMimes(): ?array
    {
        return $this->get('mimes');
    }
}
