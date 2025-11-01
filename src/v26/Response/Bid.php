<?php

declare(strict_types=1);

namespace OpenRTB\v26\Response;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=45
 */
class Bid implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
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

    public function setImpid(string $impid): static
    {
        return $this->set('impid', $impid);
    }

    public function getImpid(): ?string
    {
        return $this->get('impid');
    }

    public function setPrice(float $price): static
    {
        return $this->set('price', $price);
    }

    public function getPrice(): ?float
    {
        return $this->get('price');
    }

    public function setAdid(string $adid): static
    {
        return $this->set('adid', $adid);
    }

    public function getAdid(): ?string
    {
        return $this->get('adid');
    }

    public function setNurl(string $nurl): static
    {
        return $this->set('nurl', $nurl);
    }

    public function getNurl(): ?string
    {
        return $this->get('nurl');
    }

    public function setBurl(string $burl): static
    {
        return $this->set('burl', $burl);
    }

    public function getBurl(): ?string
    {
        return $this->get('burl');
    }

    public function setLurl(string $lurl): static
    {
        return $this->set('lurl', $lurl);
    }

    public function getLurl(): ?string
    {
        return $this->get('lurl');
    }

    public function setAdm(string $adm): static
    {
        return $this->set('adm', $adm);
    }

    public function getAdm(): ?string
    {
        return $this->get('adm');
    }

    public function setCrid(string $crid): static
    {
        return $this->set('crid', $crid);
    }

    public function getCrid(): ?string
    {
        return $this->get('crid');
    }

    public function setDealid(string $dealid): static
    {
        return $this->set('dealid', $dealid);
    }

    public function getDealid(): ?string
    {
        return $this->get('dealid');
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

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }
}
