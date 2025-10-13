<?php

declare(strict_types=1);

namespace OpenRTB\v3\Impression;

use OpenRTB\v3\BaseObject;
use OpenRTB\v3\Enums\AuctionType;

class Deal extends BaseObject
{
    /** @var array<string, class-string> */
    protected static array $schema = [
        'at' => AuctionType::class,
    ];

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setFlr(float $flr): static
    {
        return $this->set('flr', $flr);
    }

    public function getFlr(): ?float
    {
        return $this->get('flr');
    }

    public function setFlrcur(string $flrcur): static
    {
        return $this->set('flrcur', $flrcur);
    }

    public function getFlrcur(): ?string
    {
        return $this->get('flrcur');
    }

    public function setAt(AuctionType $at): static
    {
        return $this->set('at', $at);
    }

    public function getAt(): ?AuctionType
    {
        return $this->get('at');
    }

    /** @param list<string> $wseat */
    public function setWseat(array $wseat): static
    {
        return $this->set('wseat', $wseat);
    }

    /** @return list<string>|null */
    public function getWseat(): ?array
    {
        return $this->get('wseat');
    }

    /** @param list<string> $wadv */
    public function setWadv(array $wadv): static
    {
        return $this->set('wadv', $wadv);
    }

    /** @return list<string>|null */
    public function getWadv(): ?array
    {
        return $this->get('wadv');
    }
}
