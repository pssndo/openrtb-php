<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\v3\BaseObject;

class ImageFormat extends BaseObject
{
    public function setType(int $type): static
    {
        return $this->set('type', $type);
    }

    public function getType(): ?int
    {
        return $this->get('type');
    }

    public function setW(int $w): static
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setWmin(int $wmin): static
    {
        return $this->set('wmin', $wmin);
    }

    public function getWmin(): ?int
    {
        return $this->get('wmin');
    }

    public function setH(int $h): static
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }

    public function setHmin(int $hmin): static
    {
        return $this->set('hmin', $hmin);
    }

    public function getHmin(): ?int
    {
        return $this->get('hmin');
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
