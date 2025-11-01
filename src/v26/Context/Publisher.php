<?php

declare(strict_types=1);

namespace OpenRTB\v26\Context;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=33
 */
class Publisher implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'id' => 'string',
        'name' => 'string',
        'cat' => 'array',
        'domain' => 'string',
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

    public function setName(string $name): static
    {
        return $this->set('name', $name);
    }

    public function getName(): ?string
    {
        return $this->get('name');
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
