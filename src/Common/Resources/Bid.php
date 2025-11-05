<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Bid implements ObjectInterface
{
    use HasData;

    /**
     * @return array<string, string|float>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'id' => 'string',
            'price' => 'float',
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

    public function setPrice(float $price): static
    {
        return $this->set('price', $price);
    }

    public function getPrice(): ?float
    {
        return $this->get('price');
    }
}
