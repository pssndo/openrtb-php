<?php

declare(strict_types=1);

namespace OpenRTB\v25;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v25\Response\SeatBid;

/**
 * OpenRTB 2.5 Bid Response Object.
 *
 * @see https://www.iab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf
 */
class BidResponse implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, class-string|array<class-string>>
     */
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

    /** @param Collection<SeatBid>|array<SeatBid> $seatbid */
    public function setSeatbid(Collection|array $seatbid): static
    {
        return $this->set('seatbid', (array) $seatbid);
    }

    /** @return Collection<SeatBid>|null */
    public function getSeatbid(): ?Collection
    {
        $seatbid = $this->get('seatbid');
        if (is_array($seatbid)) {
            return new Collection($seatbid, SeatBid::class);
        }

        return $seatbid;
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
