<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\Common\Collection;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=21
 */
class Imp implements ObjectInterface
{
    use HasData;

    /** @var array<string, mixed> */
    protected static array $schema = [
        'metric' => [Metric::class],
        'banner' => Banner::class,
        'video' => Video::class,
        'audio' => Audio::class,
        'native' => Native::class,
        'pmp' => Pmp::class,
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    /** @param Collection<Metric>|array<Metric> $metric */
    public function setMetric(Collection|array $metric): static
    {
        return $this->set('metric', $metric);
    }

    /** @return list<Metric>|null */
    public function getMetric(): ?array
    {
        return $this->get('metric');
    }

    public function setBanner(Banner $banner): static
    {
        return $this->set('banner', $banner);
    }

    public function getBanner(): ?Banner
    {
        return $this->get('banner');
    }

    public function setVideo(Video $video): static
    {
        return $this->set('video', $video);
    }

    public function getVideo(): ?Video
    {
        return $this->get('video');
    }

    public function setAudio(Audio $audio): static
    {
        return $this->set('audio', $audio);
    }

    public function getAudio(): ?Audio
    {
        return $this->get('audio');
    }

    public function setNative(Native $native): static
    {
        return $this->set('native', $native);
    }

    public function getNative(): ?Native
    {
        return $this->get('native');
    }

    public function setPmp(Pmp $pmp): static
    {
        return $this->set('pmp', $pmp);
    }

    public function getPmp(): ?Pmp
    {
        return $this->get('pmp');
    }

    public function setInstl(int $instl): static
    {
        return $this->set('instl', $instl);
    }

    public function getInstl(): ?int
    {
        return $this->get('instl');
    }

    public function setClickbrowser(int $clickbrowser): static
    {
        return $this->set('clickbrowser', $clickbrowser);
    }

    public function getClickbrowser(): ?int
    {
        return $this->get('clickbrowser');
    }

    public function setSecure(int $secure): static
    {
        return $this->set('secure', $secure);
    }

    public function getSecure(): ?int
    {
        return $this->get('secure');
    }

    public function setExp(int $exp): static
    {
        return $this->set('exp', $exp);
    }

    public function getExp(): ?int
    {
        return $this->get('exp');
    }

    public function setBidfloor(float $bidfloor): static
    {
        return $this->set('bidfloor', $bidfloor);
    }

    public function getBidfloor(): ?float
    {
        return $this->get('bidfloor');
    }

    public function setBidfloorcur(string $bidfloorcur): static
    {
        return $this->set('bidfloorcur', $bidfloorcur);
    }

    public function getBidfloorcur(): ?string
    {
        return $this->get('bidfloorcur');
    }

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }
}
