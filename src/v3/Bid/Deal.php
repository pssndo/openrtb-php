<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v3\Enums\AuctionType;

class Deal implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, string|float|int|array<string>>
     */
    protected static array $schema = [
        'id' => 'string',
        'price' => 'float',
        'wseat' => 'array',
        'wadomain' => 'array',
        'at' => 'int',
    ];

    /**
     * @return array<string, string|float|int|array<string>>
     */
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

    public function setPrice(float $price): static
    {
        return $this->set('price', $price);
    }

    public function getPrice(): ?float
    {
        return $this->get('price');
    }

    /** @param Collection<string>|array<string> $wseat */
    public function setWseat(Collection|array $wseat): static
    {
        return $this->set('wseat', (array) $wseat);
    }

    /** @return Collection<string>|null */
    public function getWseat(): ?Collection
    {
        return new Collection($this->get('wseat') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $wadomain */
    public function setWadomain(Collection|array $wadomain): static
    {
        return $this->set('wadomain', (array) $wadomain);
    }

    /** @return Collection<string>|null */
    public function getWadomain(): ?Collection
    {
        return new Collection($this->get('wadomain') ?? [], 'string');
    }

    public function setAt(int $at): static
    {
        return $this->set('at', $at);
    }

    public function getAt(): ?AuctionType
    {
        $at = $this->get('at');
        if ($at instanceof AuctionType) {
            return $at;
        }

        return AuctionType::tryFrom($at);
    }
}
