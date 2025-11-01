<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Deal implements ObjectInterface
{
    use HasData;

    protected static array $schema = [];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setId(string $id): self
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setPrice(float $price): self
    {
        return $this->set('price', $price);
    }

    public function getPrice(): ?float
    {
        return $this->get('price');
    }

    /** @param list<string> $wseat */
    public function setWseat(array $wseat): self
    {
        return $this->set('wseat', $wseat);
    }

    /** @return list<string>|null */
    public function getWseat(): ?array
    {
        return $this->get('wseat');
    }

    /** @param list<string> $wadomain */
    public function setWadomain(array $wadomain): self
    {
        return $this->set('wadomain', $wadomain);
    }

    /** @return list<string>|null */
    public function getWadomain(): ?array
    {
        return $this->get('wadomain');
    }

    public function setAt(int $at): self
    {
        return $this->set('at', $at);
    }

    public function getAt(): ?int
    {
        return $this->get('at');
    }
}
