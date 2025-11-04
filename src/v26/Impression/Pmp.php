<?php

declare(strict_types=1);

namespace OpenRTB\v26\Impression;

use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\ObjectInterface;
use OpenRTB\Common\Collection;

/**
 * @see https://iabtechlab.com/wp-content/uploads/2022/04/OpenRTB-2-6_FINAL.pdf#page=29
 */
class Pmp implements ObjectInterface
{
    use HasData;

    /**
     * @var array<string, array<class-string>|class-string>
     */
    protected static array $schema = [
        'deals' => [Deal::class],
        'ext' => Ext::class,
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setPrivateAuction(int $private_auction): static
    {
        return $this->set('private_auction', $private_auction);
    }

    public function getPrivateAuction(): ?int
    {
        return $this->get('private_auction');
    }

    /** @param Collection<Deal>|array<Deal> $deals */
    public function setDeals(Collection|array $deals): static
    {
        return $this->set('deals', $deals);
    }

    /** @return list<Deal>|null */
    public function getDeals(): ?array
    {
        return $this->get('deals');
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
