<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Asset implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'id' => 'int',
        'req' => 'int',
        'title' => Title::class,
        'img' => Image::class,
        'data' => Data::class,
        'link' => Link::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setId(int $id): self
    {
        return $this->set('id', $id);
    }

    public function getId(): ?int
    {
        return $this->get('id');
    }

    public function setReq(int $req): self
    {
        return $this->set('req', $req);
    }

    public function getReq(): ?int
    {
        return $this->get('req');
    }

    public function setTitle(Title $title): self
    {
        return $this->set('title', $title);
    }

    public function getTitle(): ?Title
    {
        return $this->get('title');
    }

    public function setImg(Image $img): self
    {
        return $this->set('img', $img);
    }

    public function getImg(): ?Image
    {
        return $this->get('img');
    }

    public function setData(Data $data): self
    {
        return $this->set('data', $data);
    }

    public function getData(): ?Data
    {
        return $this->get('data');
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
