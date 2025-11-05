<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\Collection;
use OpenRTB\Common\Resources\Bid as CommonBid;

class Bid extends CommonBid
{
    /**
     * @return array<string, string|class-string|array<class-string>>
     */
    protected static function getBaseSchema(): array
    {
        return [
            'item' => 'string',
            'deal' => 'string',
            'cid' => 'string',
            'tactic' => 'string',
            'media' => Media::class,
            'dealobj' => Deal::class,
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

    public function setItem(string $item): static
    {
        return $this->set('item', $item);
    }

    public function getItem(): ?string
    {
        return $this->get('item');
    }

    public function setDeal(string $deal): static
    {
        return $this->set('deal', $deal);
    }

    public function getDeal(): ?string
    {
        return $this->get('deal');
    }

    public function setCid(string $cid): static
    {
        return $this->set('cid', $cid);
    }

    public function getCid(): ?string
    {
        return $this->get('cid');
    }

    public function setTactic(string $tactic): static
    {
        return $this->set('tactic', $tactic);
    }

    public function getTactic(): ?string
    {
        return $this->get('tactic');
    }

    public function setDealobj(Deal $dealobj): static
    {
        return $this->set('dealobj', $dealobj);
    }

    public function getDealobj(): ?Deal
    {
        return $this->get('dealobj');
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
