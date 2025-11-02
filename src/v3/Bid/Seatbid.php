<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\Resources\SeatBid as CommonSeatBid;
use OpenRTB\Common\Collection;

class Seatbid extends CommonSeatBid
{
    /**
     * @return array<string, string|int>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'package' => 'int',
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonSeatBid::getSchema(), static::getBaseSchema());
    }

    public function setPackage(int $package): static
    {
        return $this->set('package', $package);
    }

    public function getPackage(): ?int
    {
        return $this->get('package');
    }

    public function addBid(Bid $bid): static
    {
        $bids = $this->getBid() ?: new Collection([], Bid::class);
        $bids->add($bid);

        return $this->setBid($bids);
    }
}
