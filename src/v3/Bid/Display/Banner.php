<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid\Display;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Bid\Link;

class Banner implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'img' => 'string',
        'w' => 'int',
        'h' => 'int',
        'link' => Link::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setImg(string $img): self
    {
        return $this->set('img', $img);
    }

    public function getImg(): ?string
    {
        return $this->get('img');
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

    public function setLink(Link $link): self
    {
        return $this->set('link', $link);
    }

    public function getLink(): ?Link
    {
        return $this->get('link');
    }
}
