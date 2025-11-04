<?php

declare(strict_types=1);

namespace OpenRTB\Common\Resources;

use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Bid;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\Common\Collection;

class SeatBid implements ObjectInterface
{
    use HasData;

    /**
     * @return array<string, string|array<class-string>>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'seat' => 'string',
            'bid' => [Bid::class],
        ];
    }

    public static function getSchema(): array
    {
        return static::getBaseSchema();
    }

    public function setSeat(string $seat): static
    {
        return $this->set('seat', $seat);
    }

    public function getSeat(): ?string
    {
        return $this->get('seat');
    }

    /** @param Collection<Bid>|array<Bid> $bid */
    public function setBid(Collection|array $bid): static
    {
        $collection = $bid instanceof Collection ? $bid : new Collection($bid, Bid::class);
        return $this->set('bid', $collection);
    }

    /** @return Collection<Bid>|null */
    public function getBid(): Collection
    {
        $value = $this->get('bid');
        if ($value instanceof Collection) {
            return $value;
        }

        return new Collection(is_array($value) ? $value : [], Bid::class);
    }
}
