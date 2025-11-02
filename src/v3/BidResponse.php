<?php

declare(strict_types=1);

namespace OpenRTB\v3;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\BidResponseInterface;
use OpenRTB\v3\Bid\Seatbid;
use OpenRTB\v3\Enums\NoBidReason;
use OpenRTB\v3\Ext;

class BidResponse implements BidResponseInterface
{
    use HasData;

    protected static array $schema = [
        'id' => 'string',
        'bidid' => 'string',
        'cur' => 'string',
        'nbr' => NoBidReason::class,
        'seatbid' => [Seatbid::class],
        'ext' => Ext::class,
        'cdata' => 'string',
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

    public function setBidid(string $bidid): static
    {
        return $this->set('bidid', $bidid);
    }

    public function getBidid(): ?string
    {
        return $this->get('bidid');
    }

    public function setCur(string $cur): static
    {
        return $this->set('cur', $cur);
    }

    public function getCur(): ?string
    {
        return $this->get('cur');
    }

    public function setNbr(NoBidReason $nbr): static
    {
        return $this->set('nbr', $nbr);
    }

    public function getNbr(): ?NoBidReason
    {
        return $this->get('nbr');
    }

    /** @param list<Seatbid> $seatbid */
    public function setSeatbid(array $seatbid): static
    {
        return $this->set('seatbid', $seatbid);
    }

    /** @return list<Seatbid>|null */
    public function getSeatbid(): ?array
    {
        return $this->get('seatbid');
    }

    public function addSeatbid(Seatbid $seatbid): static
    {
        $seatbids = $this->getSeatbid() ?? [];
        $seatbids[] = $seatbid;

        return $this->setSeatbid($seatbids);
    }

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }

    public function setCdata(string $cdata): static
    {
        return $this->set('cdata', $cdata);
    }

    public function getCdata(): ?string
    {
        return $this->get('cdata');
    }
}
