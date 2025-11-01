<?php

declare(strict_types=1);

namespace OpenRTB\v26;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Response\SeatBid;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=43
 */
class BidResponse implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'seatbid' => [SeatBid::class],
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

    /** @param list<SeatBid> $seatbid */
    public function setSeatbid(array $seatbid): static
    {
        return $this->set('seatbid', $seatbid);
    }

    /** @return list<SeatBid>|null */
    public function getSeatbid(): ?array
    {
        return $this->get('seatbid');
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

    public function setNbr(int $nbr): static
    {
        return $this->set('nbr', $nbr);
    }

    public function getNbr(): ?int
    {
        return $this->get('nbr');
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
