<?php

declare(strict_types=1);

namespace OpenRTB\v25\Impression;

use OpenRTB\Common\Resources\Deal as CommonDeal;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\v25\Enums\AuctionType;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2016/03/OpenRTB-API-Specification-Version-2-5-FINAL.pdf#page=30
 */
class Deal extends CommonDeal
{
    /**
     * @return array<string, class-string|int|string>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'at' => 'int',
            'ext' => Ext::class,
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonDeal::getBaseSchema(), static::getBaseSchema());
    }

    public function setBidfloor(float $bidfloor): static
    {
        return $this->set('flr', $bidfloor);
    }

    public function getBidfloor(): ?float
    {
        return $this->get('flr');
    }

    public function setBidfloorcur(string $bidfloorcur): static
    {
        return $this->set('flrcur', $bidfloorcur);
    }

    public function getBidfloorcur(): ?string
    {
        return $this->get('flrcur');
    }

    public function setAt(int $at): static
    {
        return $this->set('at', $at);
    }

    public function getAt(): ?AuctionType
    {
        $at = $this->get('at');
        if ($at instanceof AuctionType) {
            return $at;
        }

        if (null === $at) {
            return null;
        }

        return AuctionType::tryFrom($at);
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
