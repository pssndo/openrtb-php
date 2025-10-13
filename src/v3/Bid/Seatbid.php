<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;

class Seatbid extends BaseObject
{
    /** @var array<string, array<class-string>> */
    protected static array $schema = [
        'bid' => [Bid::class],
    ];

    public function setSeat(string $seat): static
    {
        return $this->set('seat', $seat);
    }

    public function getSeat(): ?string
    {
        return $this->get('seat');
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
        $items = $this->get('bid') ?? [];
        $items[] = $bid;
        return $this->set('bid', $items);
    }

    /** @return list<Bid>|null */
    public function getBid(): ?array
    {
        return $this->get('bid');
    }
}
