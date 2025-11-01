<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context\SupplyChain;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

class Node implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setAsi(string $asi): static
    {
        return $this->set('asi', $asi);
    }

    public function getAsi(): ?string
    {
        return $this->get('asi');
    }

    public function setSid(string $sid): static
    {
        return $this->set('sid', $sid);
    }

    public function getSid(): ?string
    {
        return $this->get('sid');
    }

    public function setHp(int $hp): static
    {
        return $this->set('hp', $hp);
    }

    public function getHp(): ?int
    {
        return $this->get('hp');
    }

    public function setRid(string $rid): static
    {
        return $this->set('rid', $rid);
    }

    public function getRid(): ?string
    {
        return $this->get('rid');
    }

    public function setName(string $name): static
    {
        return $this->set('name', $name);
    }

    public function getName(): ?string
    {
        return $this->get('name');
    }

    public function setDomain(string $domain): static
    {
        return $this->set('domain', $domain);
    }

    public function getDomain(): ?string
    {
        return $this->get('domain');
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
