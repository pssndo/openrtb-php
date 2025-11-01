<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=23
 */
class Banner implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'format' => [Format::class],
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    /** @param list<Format> $format */
    public function setFormat(array $format): static
    {
        return $this->set('format', $format);
    }

    /** @return list<Format>|null */
    public function getFormat(): ?array
    {
        return $this->get('format');
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

    public function setPos(int $pos): static
    {
        return $this->set('pos', $pos);
    }

    public function getPos(): ?int
    {
        return $this->get('pos');
    }

    /** @param list<int> $btype */
    public function setBtype(array $btype): static
    {
        return $this->set('btype', $btype);
    }

    /** @return list<int>|null */
    public function getBtype(): ?array
    {
        return $this->get('btype');
    }

    /** @param list<int> $battr */
    public function setBattr(array $battr): static
    {
        return $this->set('battr', $battr);
    }

    /** @return list<int>|null */
    public function getBattr(): ?array
    {
        return $this->get('battr');
    }

    /** @param list<int> $api */
    public function setApi(array $api): static
    {
        return $this->set('api', $api);
    }

    /** @return list<int>|null */
    public function getApi(): ?array
    {
        return $this->get('api');
    }

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setVcm(int $vcm): static
    {
        return $this->set('vcm', $vcm);
    }

    public function getVcm(): ?int
    {
        return $this->get('vcm');
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
