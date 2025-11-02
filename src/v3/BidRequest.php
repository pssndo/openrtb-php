<?php

declare(strict_types=1);

namespace OpenRTB\v3;

use OpenRTB\Common\HasData;
use OpenRTB\Interfaces\BidRequestInterface;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Source;
use OpenRTB\v3\Impression\Item;

class BidRequest implements BidRequestInterface
{
    use HasData;

    protected static array $schema = [
        'id' => 'string',
        'at' => AuctionType::class,
        'tmax' => 'int',
        'test' => 'int',
        'badv' => ['string'],
        'bapp' => ['string'],
        'bcat' => ['string'],
        'cur' => ['string'],
        'wseat' => ['string'],
        'bseat' => ['string'],
        'ext' => Ext::class,
        'context' => Context::class,
        'source' => Source::class,
        'item' => [Item::class],
        'cdata' => 'string',
    ];

    public static function getSchema(): array
    {
        return static::$schema;
    }

    public function setId(string $id): static
    {
        return $this->set('id', $id);
    }

    public function getId(): ?string
    {
        return $this->get('id');
    }

    public function setTest(int $test): static
    {
        return $this->set('test', $test);
    }

    public function getTest(): ?int
    {
        return $this->get('test');
    }

    public function setTmax(int $tmax): static
    {
        return $this->set('tmax', $tmax);
    }

    public function getTmax(): ?int
    {
        return $this->get('tmax');
    }

    public function setAt(AuctionType $at): static
    {
        return $this->set('at', $at);
    }

    public function getAt(): ?AuctionType
    {
        return $this->get('at');
    }

    /** @param list<string> $cur */
    public function setCur(array $cur): static
    {
        return $this->set('cur', $cur);
    }

    /** @return list<string>|null */
    public function getCur(): ?array
    {
        return $this->get('cur');
    }

    /** @param list<string> $wseat */
    public function setWseat(array $wseat): static
    {
        return $this->set('wseat', $wseat);
    }

    /** @return list<string>|null */
    public function getWseat(): ?array
    {
        return $this->get('wseat');
    }

    /** @param list<string> $bseat */
    public function setBseat(array $bseat): static
    {
        return $this->set('bseat', $bseat);
    }

    /** @return list<string>|null */
    public function getBseat(): ?array
    {
        return $this->get('bseat');
    }

    /** @param list<string> $badv */
    public function setBadv(array $badv): static
    {
        return $this->set('badv', $badv);
    }

    /** @return list<string>|null */
    public function getBadv(): ?array
    {
        return $this->get('badv');
    }

    /** @param list<string> $bapp */
    public function setBapp(array $bapp): static
    {
        return $this->set('bapp', $bapp);
    }

    /** @return list<string>|null */
    public function getBapp(): ?array
    {
        return $this->get('bapp');
    }

    /** @param list<string> $bcat */
    public function setBcat(array $bcat): static
    {
        return $this->set('bcat', $bcat);
    }

    /** @return list<string>|null */
    public function getBcat(): ?array
    {
        return $this->get('bcat');
    }

    public function setContext(Context $context): static
    {
        return $this->set('context', $context);
    }

    public function getContext(): ?Context
    {
        return $this->get('context');
    }

    public function setSource(Source $source): static
    {
        return $this->set('source', $source);
    }

    public function getSource(): ?Source
    {
        return $this->get('source');
    }

    /** @param list<Item> $item */
    public function setItem(array $item): static
    {
        return $this->set('item', $item);
    }

    /** @return list<Item>|null */
    public function getItem(): ?array
    {
        return $this->get('item');
    }

    public function addItem(Item $item): static
    {
        $items = $this->getItem() ?? [];
        $items[] = $item;
        return $this->setItem($items);
    }

    public function setExt(Ext $ext): static
    {
        return $this->set('ext', $ext);
    }

    public function getExt(): ?Ext
    {
        return $this->get('ext');
    }

    public function setCdata(string $cdata): static
    {
        return $this->set('cdata', $cdata);
    }

    public function getCdata(): ?string
    {
        return $this->get('cdata');
    }
}
