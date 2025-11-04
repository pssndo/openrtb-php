<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\Resources\Bid as CommonBid;
use OpenRTB\Common\Collection;

class Bid extends CommonBid
{
    /**
     * @return array<string, string|class-string|array<class-string>>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'media' => Media::class,
            'deal' => Deal::class,
            'macro' => [Macro::class],
        ];
    }

    public static function getSchema(): array
    {
        return array_merge(CommonBid::getBaseSchema(), static::getBaseSchema());
    }

    public function setMedia(Media $media): static
    {
        return $this->set('media', $media);
    }

    public function getMedia(): ?Media
    {
        return $this->get('media');
    }

    public function setDeal(Deal $deal): static
    {
        return $this->set('deal', $deal);
    }

    public function getDeal(): ?Deal
    {
        return $this->get('deal');
    }

    /** @param Collection<Macro>|array<Macro> $macro */
    public function setMacro(Collection|array $macro): static
    {
        return $this->set('macro', $macro);
    }

    /** @return list<Macro>|null */
    public function getMacro(): ?array
    {
        return $this->get('macro');
    }
}
