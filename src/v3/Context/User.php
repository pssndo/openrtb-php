<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class User implements ObjectInterface
{
    use HasData;

    /** @var array<string, class-string> */
    protected static array $schema = [
        'geo' => Geo::class,
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

    /** @param list<string> $kwarray */
    public function setKwarray(array $kwarray): static
    {
        return $this->set('kwarray', $kwarray);
    }

    /** @return list<string>|null */
    public function getKwarray(): ?array
    {
        return $this->get('kwarray');
    }

    public function setConsent(string $consent): static
    {
        return $this->set('consent', $consent);
    }

    public function getConsent(): ?string
    {
        return $this->get('consent');
    }

    public function setGeo(Geo $geo): static
    {
        return $this->set('geo', $geo);
    }

    public function getGeo(): ?Geo
    {
        return $this->get('geo');
    }

    /** @param list<array<string, mixed>> $data */
    public function setData(array $data): static
    {
        return $this->set('data', $data);
    }

    /** @return list<array<string, mixed>>|null */
    public function getData(): ?array
    {
        return $this->get('data');
    }

    /** @param list<array<string, mixed>> $eids */
    public function setEids(array $eids): static
    {
        return $this->set('eids', $eids);
    }

    /** @return list<array<string, mixed>>|null */
    public function getEids(): ?array
    {
        return $this->get('eids');
    }
}
