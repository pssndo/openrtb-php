<?php

declare(strict_types=1);

namespace OpenRTB\v3;

use OpenRTB\Common\Collection;
use OpenRTB\Common\HasData;
use OpenRTB\Common\Resources\Ext;
use OpenRTB\Interfaces\BidRequestInterface;
use OpenRTB\v3\Context\Context;
use OpenRTB\v3\Context\Source;
use OpenRTB\v3\Enums\AuctionType;
use OpenRTB\v3\Impression\Item;

class BidRequest implements BidRequestInterface
{
    use HasData;

    /**
     * @var array<string, string|class-string|array<class-string>|array<string>|int>
     */
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

    /**
     * @return array<string, string|class-string|array<class-string>|array<string>|int>
     */
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

    /** @param Collection<string>|array<string> $cur */
    public function setCur(Collection|array $cur): static
    {
        return $this->set('cur', is_array($cur) ? $cur : $cur->toArray());
    }

    /** @return Collection<string>|null */
    public function getCur(): ?Collection
    {
        return new Collection($this->get('cur') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $wseat */
    public function setWseat(Collection|array $wseat): static
    {
        return $this->set('wseat', is_array($wseat) ? $wseat : $wseat->toArray());
    }

    /** @return Collection<string>|null */
    public function getWseat(): ?Collection
    {
        return new Collection($this->get('wseat') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $bseat */
    public function setBseat(Collection|array $bseat): static
    {
        return $this->set('bseat', is_array($bseat) ? $bseat : $bseat->toArray());
    }

    /** @return Collection<string>|null */
    public function getBseat(): ?Collection
    {
        return new Collection($this->get('bseat') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $badv */
    public function setBadv(Collection|array $badv): static
    {
        return $this->set('badv', is_array($badv) ? $badv : $badv->toArray());
    }

    /** @return Collection<string>|null */
    public function getBadv(): ?Collection
    {
        return new Collection($this->get('badv') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $bapp */
    public function setBapp(Collection|array $bapp): static
    {
        return $this->set('bapp', is_array($bapp) ? $bapp : $bapp->toArray());
    }

    /** @return Collection<string>|null */
    public function getBapp(): ?Collection
    {
        return new Collection($this->get('bapp') ?? [], 'string');
    }

    /** @param Collection<string>|array<string> $bcat */
    public function setBcat(Collection|array $bcat): static
    {
        return $this->set('bcat', is_array($bcat) ? $bcat : $bcat->toArray());
    }

    /** @return Collection<string>|null */
    public function getBcat(): ?Collection
    {
        return new Collection($this->get('bcat') ?? [], 'string');
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

    /** @param Collection<Item> $item */
    public function setItem(Collection $item): static
    {
        return $this->set('item', $item);
    }

    /** @return Collection<Item>|null */
    public function getItem(): ?Collection
    {
        $value = $this->get('item');
        if ($value instanceof Collection) {
            return $value;
        }
        if (is_array($value)) {
            return new Collection($value, Item::class);
        }

        return null;
    }

    public function addItem(Item $item): static
    {
        $items = $this->getItem() ?: new Collection([], Item::class);
        $items->add($item);

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
