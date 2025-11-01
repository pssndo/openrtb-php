<?php

declare(strict_types=1);

namespace OpenRTB\v3\Bid;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\ObjectInterface;

class Bid implements ObjectInterface
{
    use HasData;

    protected static array $schema = [
        'id' => 'string',
        'price' => 'float',
        'media' => Media::class,
        'deal' => Deal::class,
        'macro' => [Macro::class],
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setId(string $id): self
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setPrice(float $price): self
    {
        return $this->set('price', $price);
    }

    public function getPrice(): ?float
    {
        return $this->get('price');
    }

    public function setMedia(Media $media): self
    {
        return $this->set('media', $media);
    }

    public function getMedia(): ?Media
    {
        return $this->get('media');
    }

    public function setDeal(Deal $deal): self
    {
        return $this->set('deal', $deal);
    }

    public function getDeal(): ?Deal
    {
        return $this->get('deal');
    }

    /** @param list<Macro> $macro */
    public function setMacro(array $macro): self
    {
        return $this->set('macro', $macro);
    }

    /** @return list<Macro>|null */
    public function getMacro(): ?array
    {
        return $this->get('macro');
    }
}
