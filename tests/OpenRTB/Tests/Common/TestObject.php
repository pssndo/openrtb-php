<?php

declare(strict_types=1);

namespace OpenRTB\Tests\Common;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class TestObject implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|array<string>>
     */
    protected static array $schema = [
        'id' => 'string',
        'tags' => ['string'], // Array of scalar strings
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

    /** @param list<string> $tags */
    public function setTags(array $tags): static
    {
        return $this->set('tags', $tags);
    }

    /** @return list<string>|null */
    public function getTags(): ?array
    {
        return $this->get('tags');
    }
}
