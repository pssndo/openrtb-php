<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\v3\BaseObject;

class Bid extends BaseObject
{
    /** @var array<string, class-string> */
    protected static array $schema = [
        'media' => Media::class,
    ];

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setItem(string $item): static
    {
        return $this->set('item', $item);
    }

    public function getItem(): ?string
    {
        return $this->get('item');
    }

    public function setPrice(float $price): static
    {
        return $this->set('price', $price);
    }

    public function getPrice(): ?float
    {
        return $this->get('price');
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

    public function setPurl(string $purl): static
    {
        return $this->set('purl', $purl);
    }

    public function getPurl(): ?string
    {
        return $this->get('purl');
    }

    public function setBurl(string $burl): static
    {
        return $this->set('burl', $burl);
    }

    public function getBurl(): ?string
    {
        return $this->get('burl');
    }

    public function setLurl(string $lurl): static
    {
        return $this->set('lurl', $lurl);
    }

    public function getLurl(): ?string
    {
        return $this->get('lurl');
    }

    public function setMid(string $mid): static
    {
        return $this->set('mid', $mid);
    }

    public function getMid(): ?string
    {
        return $this->get('mid');
    }

    /** @param list<string> $macro */
    public function setMacro(array $macro): static
    {
        return $this->set('macro', $macro);
    }

    /** @return list<string>|null */
    public function getMacro(): ?array
    {
        return $this->get('macro');
    }

    public function setMedia(Media $media): static
    {
        return $this->set('media', $media);
    }

    public function getMedia(): ?Media
    {
        return $this->get('media');
    }
}
