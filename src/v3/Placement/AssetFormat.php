<?php

declare(strict_types=1);

namespace OpenRTB\v3\Placement;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class AssetFormat implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'title' => TitleFormat::class,
        'img' => ImageFormat::class,
        'video' => VideoPlacement::class,
        'data' => DataFormat::class,
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

    public function setTitle(TitleFormat $title): self
    {
        return $this->set('title', $title);
    }

    public function getTitle(): ?TitleFormat
    {
        return $this->get('title');
    }

    public function setImg(ImageFormat $img): self
    {
        return $this->set('img', $img);
    }

    public function getImg(): ?ImageFormat
    {
        return $this->get('img');
    }

    public function setVideo(VideoPlacement $video): self
    {
        return $this->set('video', $video);
    }

    public function getVideo(): ?VideoPlacement
    {
        return $this->get('video');
    }

    public function setData(DataFormat $data): self
    {
        return $this->set('data', $data);
    }

    public function getData(): ?DataFormat
    {
        return $this->get('data');
    }
}
