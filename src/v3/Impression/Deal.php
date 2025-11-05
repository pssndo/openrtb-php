<?php

declare(strict_types=1);

namespace OpenRTB\v3\Impression;

use OpenRTB\Common\Resources\Deal as CommonDeal;
use OpenRTB\v3\Enums\AuctionType;

class Deal extends CommonDeal
{
    /**
     * @return array<string, class-string|string|float|int|array<string>>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'at' => AuctionType::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonDeal::getBaseSchema(), static::getBaseSchema());
    }

    public function setAt(AuctionType $at): static
    {
        return $this->set('at', $at->value);
    }

    public function getAt(): ?AuctionType
    {
        $at = $this->get('at');
        if ($at instanceof AuctionType) {
            return $at;
        }

        return AuctionType::tryFrom($at);
    }
}
