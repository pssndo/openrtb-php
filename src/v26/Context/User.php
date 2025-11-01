<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=39
 */
class User implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'geo' => Geo::class,
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

    public function setBuyeruid(string $buyeruid): static
    {
        return $this->set('buyeruid', $buyeruid);
    }

    public function getBuyeruid(): ?string
    {
        return $this->get('buyeruid');
    }

    public function setYob(int $yob): static
    {
        return $this->set('yob', $yob);
    }

    public function getYob(): ?int
    {
        return $this->get('yob');
    }

    public function setGender(string $gender): static
    {
        return $this->set('gender', $gender);
    }

    public function getGender(): ?string
    {
        return $this->get('gender');
    }

    public function setKeywords(string $keywords): static
    {
        return $this->set('keywords', $keywords);
    }

    public function getKeywords(): ?string
    {
        return $this->get('keywords');
    }

    public function setGeo(Geo $geo): static
    {
        return $this->set('geo', $geo);
    }

    public function getGeo(): ?Geo
    {
        return $this->get('geo');
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
