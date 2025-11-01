<?php

declare(strict_types=1);

namespace OpenRTB\v3\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Dooh implements ObjectInterface
{
    use HasData;

    protected static array $schema = [];

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

    public function setName(string $name): static
    {
        return $this->set('name', $name);
    }

    public function getName(): ?string
    {
        return $this->get('name');
    }

    /** @param list<string> $venuetype */
    public function setVenuetype(array $venuetype): static
    {
        return $this->set('venuetype', $venuetype);
    }

    /** @return list<string>|null */
    public function getVenuetype(): ?array
    {
        return $this->get('venuetype');
    }

    public function setDomain(string $domain): static
    {
        return $this->set('domain', $domain);
    }

    public function getDomain(): ?string
    {
        return $this->get('domain');
    }

    /** @param list<string> $cat */
    public function setCat(array $cat): static
    {
        return $this->set('cat', $cat);
    }

    /** @return list<string>|null */
    public function getCat(): ?array
    {
        return $this->get('cat');
    }

    public function setCattax(int $cattax): static
    {
        return $this->set('cattax', $cattax);
    }

    public function getCattax(): ?int
    {
        return $this->get('cattax');
    }
}
