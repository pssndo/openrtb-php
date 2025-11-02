<?php

declare(strict_types=1);

namespace OpenRTB\v26\Response;

use OpenRTB\Common\Resources\Ext;
use OpenRTB\Common\Resources\SeatBid as CommonSeatBid;
use OpenRTB\v26\Response\Bid;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=44
 */
class SeatBid extends CommonSeatBid
{
    /**
     * @return array<string, string|class-string|int|array<class-string>>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'group' => 'int',
            'ext' => Ext::class,
            'bid' => [Bid::class], // Override to use v26 Bid class
        ];
    }

    public static function getSchema(): array
    {
        // Merge with parent schema, with current class's schema taking precedence
        return array_merge(parent::getSchema(), static::getBaseSchema());
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
