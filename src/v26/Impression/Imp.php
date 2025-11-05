<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=21
 */
class Imp implements ObjectInterface
{
    use HasData;

    /** @var array<string, mixed> */
    protected static array $schema = [
        'id' => 'string',
        'metric' => [Metric::class],
        'banner' => Banner::class,
        'video' => Video::class,
        'audio' => Audio::class,
        'native' => Native::class,
        'pmp' => Pmp::class,
        'displaymanager' => 'string',
        'displaymanagerver' => 'string',
        'instl' => 'int',
        'tagid' => 'string',
        'bidfloor' => 'float',
        'bidfloorcur' => 'string',
        'clickbrowser' => 'int',
        'secure' => 'int',
        'iframebuster' => ['string'],
        'rwdd' => 'int',
        'ssai' => 'int',
        'exp' => 'int',
        'dt' => 'float',
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

    public function setDisplaymanager(string $displaymanager): static
    {
        return $this->set('displaymanager', $displaymanager);
    }

    public function getDisplaymanager(): ?string
    {
        return $this->get('displaymanager');
    }

    public function setDisplaymanagerver(string $displaymanagerver): static
    {
        return $this->set('displaymanagerver', $displaymanagerver);
    }

    public function getDisplaymanagerver(): ?string
    {
        return $this->get('displaymanagerver');
    }

    public function setTagid(string $tagid): static
    {
        return $this->set('tagid', $tagid);
    }

    public function getTagid(): ?string
    {
        return $this->get('tagid');
    }

    /** @param array<string> $iframebuster */
    public function setIframebuster(array $iframebuster): static
    {
        return $this->set('iframebuster', $iframebuster);
    }

    /** @return list<string>|null */
    public function getIframebuster(): ?array
    {
        return $this->get('iframebuster');
    }

    public function setRwdd(int $rwdd): static
    {
        return $this->set('rwdd', $rwdd);
    }

    public function getRwdd(): ?int
    {
        return $this->get('rwdd');
    }

    public function setSsai(int $ssai): static
    {
        return $this->set('ssai', $ssai);
    }

    public function getSsai(): ?int
    {
        return $this->get('ssai');
    }

    public function setDt(float $dt): static
    {
        return $this->set('dt', $dt);
    }

    public function getDt(): ?float
    {
        return $this->get('dt');
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
