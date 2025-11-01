<?php

declare(strict_types=1);

namespace OpenRTB\v26\Response;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\v26\Ext;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=44
 */
class SeatBid implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'bid' => [Bid::class],
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    /** @param list<Bid> $bid */
    public function setBid(array $bid): static
    {
        return $this->set('bid', $bid);
    }

    /** @return list<Bid>|null */
    public function getBid(): ?array
    {
        return $this->get('bid');
    }

    public function setSeat(string $seat): static
    {
        return $this->set('seat', $seat);
    }

    public function getSeat(): ?string
    {
        return $this->get('seat');
    }

    public function setGroup(int $group): static
    {
        return $this->set('group', $group);
    }

    public function getGroup(): ?int
    {
        return $this->get('group');
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
