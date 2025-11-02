<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

/**
 * Base class for entities with common properties (id, name, domain, cat).
 * Used by Publisher and Producer which have identical schemas.
 */
abstract class EntityBase implements ObjectInterface
{
    use HasData;

    /**
     * @return array<string, string|array<string>>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'id' => 'string',
            'name' => 'string',
            'domain' => 'string',
            'cat' => 'array',
        ];
    }

    public static function getSchema(): array
    {
        return static::getBaseSchema();
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
}