<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid\Display;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Bid\Link;

class Banner implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|int|class-string>
     */
    protected static array $schema = [
        'img' => 'string',
        'w' => 'int',
        'h' => 'int',
        'link' => Link::class,
    ];

    /**
     * @return array<string, string|int|class-string>
     */
    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setImg(string $img): static
    {
        return $this->set('img', $img);
    }

    public function getImg(): ?string
    {
        return $this->get('img');
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

    public function setLink(Link $link): static
    {
        return $this->set('link', $link);
    }

    public function getLink(): ?Link
    {
        return $this->get('link');
    }
}
