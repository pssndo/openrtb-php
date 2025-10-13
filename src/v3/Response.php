<?php

declare(strict_types=1);

namespace OpenRTB\v3;

use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Enums\NoBidReason;

class Response extends BaseObject
{
    /** @var array<string, class-string|array<class-string>> */
    protected static array $schema = [
        'nbr' => NoBidReason::class,
        'seatbid' => [Seatbid::class],
    ];

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setBidid(string $bidid): static
    {
        return $this->set('bidid', $bidid);
    }

    public function getBidid(): ?string
    {
        return $this->get('bidid');
    }

    public function setNbr(NoBidReason $nbr): static
    {
        return $this->set('nbr', $nbr);
    }

    public function getNbr(): ?NoBidReason
    {
        return $this->get('nbr');
    }

    public function setCur(string $cur): static
    {
        return $this->set('cur', $cur);
    }

    public function getCur(): ?string
    {
        return $this->get('cur');
    }

    public function setCdata(string $cdata): static
    {
        return $this->set('cdata', $cdata);
    }

    public function getCdata(): ?string
    {
        return $this->get('cdata');
    }

    public function addSeatbid(Seatbid $seatbid): static
    {
        $items = $this->get('seatbid') ?? [];
        $items[] = $seatbid;
        return $this->set('seatbid', $items);
    }

    /** @return list<Seatbid>|null */
    public function getSeatbid(): ?array
    {
        return $this->get('seatbid');
    }
}
