<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;

class Image extends BaseObject
{
    public function setUrl(string $url): self
    {
        return $this->set('url', $url);
    }

    public function getUrl(): ?string
    {
        return $this->get('url');
    }

    public function setW(int $w): self
    {
        return $this->set('w', $w);
    }

    public function getW(): ?int
    {
        return $this->get('w');
    }

    public function setH(int $h): self
    {
        return $this->set('h', $h);
    }

    public function getH(): ?int
    {
        return $this->get('h');
    }
}
